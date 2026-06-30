<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
class SolicitudController extends Controller
{
    private function resolverAsesor(): int
    {
        $doc = Session::get('usuario_logeado');
        $personal = DB::table('dpersonal')->where('numerodni', $doc)->first();
        if (!$personal) {
            return 31;
        }
        $link = DB::table('dpersonalasesor')
            ->where('pkpersonal', $personal->pkpersonal)
            ->first();
        return $link ? $link->pkasesor : 31;
    }

    public function mostrarDashboard()
    {
        if (!Session::has('usuario_logeado')) {
            return redirect('/login');
        }
        $rol = Session::get('usuario_rol');
        if ($rol === 'cliente') {
            return $this->dashboardCliente();
        }
        if (in_array($rol, ['asesor', 'administrador', 'riesgos', 'gerencia'], true)) {
            return $this->dashboardAsesor();
        }
        return redirect('/login');
    }

    private function dashboardCliente()
    {
        $pkusuario = Session::get('usuario_logeado'); // ahora es pkusuario
        $clienteRow = DB::table('usuarios_homebanking')
            ->join('dcliente', 'usuarios_homebanking.pkcliente', '=', 'dcliente.pkcliente')
            ->where('usuarios_homebanking.pkusuario', $pkusuario)
            ->select('dcliente.pkcliente', 'dcliente.nomcliente',
                     'dcliente.destipodocumentoidentidad',
                     'dcliente.numerodocumentoidentidad')
            ->first();
        if (!$clienteRow) {
            return redirect('/login')->with('error', 'No se encontró el cliente.');
        }
        $pkcliente = $clienteRow->pkcliente;
        $cuentas = DB::table('fcuentaahorro')
            ->join('dcuentaahorro', 'fcuentaahorro.pkcuentaahorro', '=', 'dcuentaahorro.pkcuentaahorro')
            ->join('dproductoahorro', 'fcuentaahorro.pkproductoahorro', '=', 'dproductoahorro.pkproductoahorro')
            ->join('destadocuenta', 'fcuentaahorro.pkestadocuenta', '=', 'destadocuenta.pkestadocuenta')
            ->where('fcuentaahorro.pkcliente', $pkcliente)
            ->select(
                'dcuentaahorro.codcuentaahorro',
                'dproductoahorro.destipoproducto as producto',
                'destadocuenta.desestadocuenta as estado',
                DB::raw('MAX(fcuentaahorro.periododia) as ultimo_dia'),
                DB::raw('MAX(fcuentaahorro.montosaldocapitaltotal) as saldo')
            )
            ->groupBy('dcuentaahorro.codcuentaahorro', 'dproductoahorro.destipoproducto', 'destadocuenta.desestadocuenta')
            ->get();
        $ahorrosTotal = $cuentas->sum('saldo');
        $ultimoPeriodo = DB::table('fagcuentacredito')
            ->where('pkcliente', $pkcliente)
            ->max('periodomes');
        $prestamos = collect();
        $deudaTotal = 0;
        if ($ultimoPeriodo) {
            $prestamos = DB::table('fagcuentacredito')
                ->join('dcuentacredito', 'fagcuentacredito.pkcuentacredito', '=', 'dcuentacredito.pkcuentacredito')
                ->join('dproducto', 'fagcuentacredito.pkproducto', '=', 'dproducto.pkproducto')
                ->join('dcalificacioncrediticia', 'fagcuentacredito.pkcalificacioncrediticiainterna', '=', 'dcalificacioncrediticia.pkcalificacioncrediticia')
                ->where('fagcuentacredito.pkcliente', $pkcliente)
                ->where('fagcuentacredito.periodomes', $ultimoPeriodo)
                ->select(
                    'dcuentacredito.codcuentacredito',
                    'dproducto.desproducto as producto',
                    'dcalificacioncrediticia.descalificacioncrediticia as calificacion',
                    'fagcuentacredito.montosaldocapital as saldo'
                )
                ->get();
            $deudaTotal = $prestamos->sum('saldo');
        }
        $solCliente = DB::table('dsolicitud')
            ->join('dsolicitudestado', 'dsolicitud.pksolicitudestado', '=', 'dsolicitudestado.pksolicitudestado')
            ->join('dproducto', 'dsolicitud.pkproducto', '=', 'dproducto.pkproducto')
            ->where('dsolicitud.pkcliente', $pkcliente)
            ->whereNotIn('dsolicitud.pksolicitudestado', [4, 5])
            ->select(
                'dsolicitud.codsolicitud',
                'dsolicitud.montosolicitudcredito as monto',
                'dsolicitud.nrocuotasolicitud as cuotas',
                'dsolicitud.fechasolicitudcredito as fecha',
                'dproducto.desproducto as producto',
                'dsolicitudestado.dessolicitudestado as estado'
            )
            ->orderBy('dsolicitud.pksolicitud', 'desc')
            ->get();
        return view('banca-internet', compact(
            'clienteRow', 'cuentas', 'ahorrosTotal',
            'prestamos', 'deudaTotal', 'solCliente'
        ));
    }

    private function dashboardAsesor()
    {
        $pkasesor     = $this->resolverAsesor();
        $ultimoPeriodo = DB::table('fagcuentacredito')->max('periodomes') ?? 202512;
        $kpis = DB::table('fagcuentacredito')
            ->where('pkasesor', $pkasesor)
            ->where('periodomes', $ultimoPeriodo)
            ->select(
                DB::raw('sum(montosaldocapital)  as total_cartera'),
                DB::raw('sum(car_vig_capital)     as vigente'),
                DB::raw('sum(car_ven_capital)     as vencida'),
                DB::raw('count(pkcuentacredito)   as num_creditos'),
                DB::raw('count(distinct pkcliente) as num_clientes')
            )
            ->first();
        $totalCartera = (float) ($kpis->total_cartera ?? 0);
        $vigente      = (float) ($kpis->vigente      ?? 0);
        $vencida      = (float) ($kpis->vencida      ?? 0);
        $numCreditos  = (int)   ($kpis->num_creditos  ?? 0);
        $numClientes  = (int)   ($kpis->num_clientes  ?? 0);
        $ratioMora    = $totalCartera > 0 ? round(($vencida / $totalCartera) * 100, 1) : 0;
        $calificaciones = DB::table('fagcuentacredito')
            ->join('dcalificacioncrediticia',
                   'fagcuentacredito.pkcalificacioncrediticiainterna', '=',
                   'dcalificacioncrediticia.pkcalificacioncrediticia')
            ->where('fagcuentacredito.pkasesor', $pkasesor)
            ->where('fagcuentacredito.periodomes', $ultimoPeriodo)
            ->select(
                'dcalificacioncrediticia.codcalificacioncrediticia as cod',
                'dcalificacioncrediticia.descalificacioncrediticia as label',
                DB::raw('sum(fagcuentacredito.montosaldocapital) as monto')
            )
            ->groupBy('dcalificacioncrediticia.codcalificacioncrediticia',
                      'dcalificacioncrediticia.descalificacioncrediticia')
            ->orderBy('dcalificacioncrediticia.codcalificacioncrediticia')
            ->get();
$bandeja = DB::table('dsolicitud')
            ->join('dcliente', 'dsolicitud.pkcliente', '=', 'dcliente.pkcliente')
            ->join('dsolicitudestado', 'dsolicitud.pksolicitudestado', '=', 'dsolicitudestado.pksolicitudestado')
            ->join('dproducto', 'dsolicitud.pkproducto', '=', 'dproducto.pkproducto')
            ->leftJoin('dnivelaprobacion', 'dsolicitud.pknivelaprobacion', '=', 'dnivelaprobacion.pknivelaprobacion')
            ->where(function ($q) use ($pkasesor) {
                $q->where('dsolicitud.pkasesor', $pkasesor)
                  ->orWhere('dsolicitud.pksolicitudestado', 1);
            })
            ->select(
                'dsolicitud.pksolicitud',
                'dsolicitud.codsolicitud',
                'dcliente.nomcliente as cliente',
                'dcliente.destipodocumentoidentidad as tipo_doc',
                'dcliente.numerodocumentoidentidad as nro_doc',
                'dsolicitud.montosolicitudcredito as monto',
                'dsolicitud.nrocuotasolicitud as cuotas',
                'dproducto.desproducto as tipo',
                'dsolicitudestado.dessolicitudestado as estado',
                'dsolicitud.pksolicitudestado as estado_id',
                'dsolicitud.fechasolicitudcredito as fecha',
                'dnivelaprobacion.desnivelaprobacion as nivel_aprobacion'
            )
            ->orderBy('dsolicitud.pksolicitud', 'desc')
            ->get();
        $moraKpis = DB::table('fagcuentacredito')
            ->where('periodomes', $ultimoPeriodo)
            ->selectRaw("
                COUNT(*) FILTER (WHERE diasatrasocredito BETWEEN 1  AND 30)  AS cnt_prev,
                COUNT(*) FILTER (WHERE diasatrasocredito BETWEEN 31 AND 60)  AS cnt_temp,
                COUNT(*) FILTER (WHERE diasatrasocredito BETWEEN 61 AND 120) AS cnt_tard,
                COUNT(*) FILTER (WHERE diasatrasocredito BETWEEN 121 AND 180 AND flagjudicial = 'N') AS cnt_judi,
                COUNT(*) FILTER (WHERE diasatrasocredito > 180 OR flagcastigado = 'S') AS cnt_cast,
                COALESCE(SUM(montosaldovencido) FILTER (WHERE diasatrasocredito BETWEEN 1  AND 30),  0) AS mon_prev,
                COALESCE(SUM(montosaldovencido) FILTER (WHERE diasatrasocredito BETWEEN 31 AND 60),  0) AS mon_temp,
                COALESCE(SUM(montosaldovencido) FILTER (WHERE diasatrasocredito BETWEEN 61 AND 120), 0) AS mon_tard,
                COALESCE(SUM(montosaldovencido) FILTER (WHERE diasatrasocredito BETWEEN 121 AND 180 AND flagjudicial = 'N'), 0) AS mon_judi,
                COALESCE(SUM(montosaldovencido) FILTER (WHERE diasatrasocredito > 180 OR flagcastigado = 'S'), 0) AS mon_cast,
                COALESCE(SUM(montosaldocapital), 0) AS total_cartera_global,
                COALESCE(SUM(montosaldovencido), 0) AS total_vencida_global
            ")
            ->first();
        $creditosMorosos = DB::table('fagcuentacredito')
            ->join('dcliente',      'fagcuentacredito.pkcliente',      '=', 'dcliente.pkcliente')
            ->join('dcuentacredito','fagcuentacredito.pkcuentacredito', '=', 'dcuentacredito.pkcuentacredito')
            ->where('fagcuentacredito.pkasesor',   $pkasesor)
            ->where('fagcuentacredito.periodomes', $ultimoPeriodo)
            ->where('fagcuentacredito.diasatrasocredito', '>', 0)
            ->select(
                'fagcuentacredito.pkcuentacredito',
                'dcuentacredito.codcuentacredito',
                'dcliente.nomcliente as cliente',
                'dcliente.numerodocumentoidentidad as nro_doc',
                'dcliente.destipodocumentoidentidad as tipo_doc',
                'fagcuentacredito.diasatrasocredito as dias',
                'fagcuentacredito.montosaldocapital as saldo_capital',
                'fagcuentacredito.montosaldovencido as saldo_vencido',
                'fagcuentacredito.flagjudicial',
                'fagcuentacredito.flagcastigado'
            )
            ->orderByDesc('fagcuentacredito.diasatrasocredito')
            ->get()
            ->map(function ($c) {
                $c->banda = match(true) {
                    ($c->flagcastigado === 'S' || $c->dias > 180) => 'CASTIGO',
                    ($c->flagjudicial  === 'S' || $c->dias > 120) => 'JUDICIAL',
                    $c->dias > 60  => 'TARDÍA',
                    $c->dias > 30  => 'TEMPRANA',
                    default        => 'PREVENTIVA',
                };
                return $c;
            });
        $historialGestiones = DB::table('fgestioncobranza')
            ->join('dcuentacredito',    'fgestioncobranza.pkcuentacredito', '=', 'dcuentacredito.pkcuentacredito')
            ->join('dtipogestioncobranza','fgestioncobranza.pktipogestion',  '=', 'dtipogestioncobranza.pktipogestion')
            ->join('fagcuentacredito',   'fgestioncobranza.pkcuentacredito', '=', 'fagcuentacredito.pkcuentacredito')
            ->join('dcliente',           'fagcuentacredito.pkcliente',       '=', 'dcliente.pkcliente')
            ->where('fagcuentacredito.pkasesor',   $pkasesor)
            ->where('fagcuentacredito.periodomes', $ultimoPeriodo)
            ->select(
                'fgestioncobranza.pkgestion',
                'dcuentacredito.codcuentacredito',
                'dcliente.nomcliente as cliente',
                'dtipogestioncobranza.destipogestion as tipo_gestion',
                'fgestioncobranza.fechagestion',
                'fgestioncobranza.banda',
                'fgestioncobranza.resultado',
                'fgestioncobranza.diasatrasoalmomento as dias'
            )
            ->orderByDesc('fgestioncobranza.pkgestion')
            ->limit(50)
            ->get();
        $tiposGestion = DB::table('dtipogestioncobranza')
            ->orderBy('codtipogestion')
            ->get();
        return view('core-asesor', compact(
            'pkasesor', 'ultimoPeriodo',
            'totalCartera', 'vigente', 'vencida',
            'numCreditos', 'numClientes', 'ratioMora',
            'calificaciones', 'bandeja',
            'moraKpis', 'creditosMorosos', 'historialGestiones', 'tiposGestion'
        ));
    }

    public function mostrarFormulario()
    {
        if (!Session::has('usuario_logeado') || Session::get('usuario_rol') !== 'cliente') {
            return redirect('/login')->with('error', 'Debe iniciar sesión como cliente para solicitar un préstamo.');
        }
$pkusuario = Session::get('usuario_logeado');
        $cliente = DB::table('usuarios_homebanking')
            ->join('dcliente', 'usuarios_homebanking.pkcliente', '=', 'dcliente.pkcliente')
            ->where('usuarios_homebanking.pkusuario', $pkusuario)
            ->select('dcliente.nomcliente', 'dcliente.destipodocumentoidentidad', 'dcliente.numerodocumentoidentidad')
            ->first();
        return view('solicitar-prestamo', compact('cliente'));
    }

    public function guardarSolicitud(Request $request)
    {
        if (!Session::has('usuario_logeado') || Session::get('usuario_rol') !== 'cliente') {
            return redirect('/login')->with('error', 'Sesión no válida.');
        }
        $request->validate([
            'monto'  => 'required|numeric|min:100|max:100000',
            'cuotas' => 'required|integer|min:3|max:72',
        ], [
            'monto.required'  => 'El monto es obligatorio.',
            'monto.numeric'   => 'El monto debe ser un número.',
            'monto.min'       => 'El monto mínimo a solicitar es S/ 100.',
            'monto.max'       => 'El monto máximo a solicitar es S/ 100,000.',
            'cuotas.required' => 'Las cuotas son obligatorias.',
            'cuotas.integer'  => 'Las cuotas deben ser un número entero.',
            'cuotas.min'      => 'El plazo mínimo es de 3 meses.',
            'cuotas.max'      => 'El plazo máximo es de 72 meses.',
        ]);
        $pkusuario = Session::get('usuario_logeado');
        $cliente = DB::table('usuarios_homebanking')
            ->join('dcliente', 'usuarios_homebanking.pkcliente', '=', 'dcliente.pkcliente')
            ->where('usuarios_homebanking.pkusuario', $pkusuario)
            ->select('dcliente.pkcliente')
            ->first();
        if (!$cliente) {
            return back()->with('error', 'No se encontró la información del cliente en el sistema.');
        }
        $codSolicitud = 'SOL' . date('Ymd') . str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT);
        try {
            DB::table('dsolicitud')->insert([
                'codsolicitud'                => $codSolicitud,
                'pkcliente'                   => $cliente->pkcliente,
                'pksolicitudestado'           => 1,
                'pksolicitudsituacion'        => 1,
                'pkmoneda'                    => 1,
                'pkproducto'                  => 8,
                'montosolicitudcredito'       => $request->input('monto'),
                'nrocuotasolicitud'           => $request->input('cuotas'),
                'plazosolicitudcredito'       => $request->input('cuotas') * 30,
                'fechasolicitudcredito'       => date('Y-m-d'),
                'pkagencia'                   => 1,
                'pkasesor'                    => 31,
                'nrodiasgracia'               => 0,
                'flaglibreamortizacioncredito'=> 'N',
                'fechahoracreacion'           => now(),
                'fechahoraultmodificacion'    => now(),
                'fecultactualizacion'         => now(),
            ]);
            return redirect('/dashboard')->with('success', 'Su pre-solicitud (' . $codSolicitud . ') fue enviada con éxito y se encuentra en evaluación.');
        } catch (\Throwable $e) {
            return back()->with('error', 'Error al procesar su solicitud: ' . $e->getMessage())->withInput();
        }
    }

    private function evaluarClientePrivado(int $pkcliente, float $montoSolicitado = 0, int $cuotas = 1, float $tasaTEA = 33.06): array
    {
        $cliente = DB::table('dcliente')
            ->where('pkcliente', $pkcliente)
            ->select('montodeingreso', 'montoingresoneto')
            ->first();
        $ingresoMensual = (float) ($cliente->montodeingreso ?? $cliente->montoingresoneto ?? 0);
        $historial = DB::table('fagcuentacredito')
            ->where('pkcliente', $pkcliente)
            ->selectRaw('
                MAX(diasatrasocredito) as max_dias_atraso,
                COUNT(*) FILTER (WHERE flagcastigado = \'S\') as creditos_castigados,
                COALESCE(SUM(montosaldocapital), 0) as deuda_actual_total
            ')
            ->first();
        $maxDiasAtraso  = (int) ($historial->max_dias_atraso ?? 0);
        $creditosCastig = (int) ($historial->creditos_castigados ?? 0);
        $deudaActual    = (float) ($historial->deuda_actual_total ?? 0);
        $score = 100;
        if ($creditosCastig > 0)               $score -= 60;
        if ($maxDiasAtraso > 120)               $score -= 30;
        elseif ($maxDiasAtraso > 60)            $score -= 20;
        elseif ($maxDiasAtraso > 30)            $score -= 10;
        elseif ($maxDiasAtraso > 0)             $score -= 5;
        $score = max(0, min(100, $score));
        $scoreNivel = match(true) {
            $score >= 80 => 'BAJO',
            $score >= 50 => 'MEDIO',
            default      => 'ALTO',
        };
        $scoreColor = match($scoreNivel) {
            'BAJO'  => 'verde',
            'MEDIO' => 'amarillo',
            'ALTO'  => 'rojo',
        };
        $rds = null;
        $rdsNivel = null;
        $rdsColor = 'gris';
        $cuotaEstimada = 0;
        if ($ingresoMensual > 0 && $montoSolicitado > 0 && $cuotas > 0) {
            $tem = (pow(1 + ($tasaTEA / 100), 1 / 12) - 1);
            $cuotaEstimada = $tem > 0
                ? ($montoSolicitado * $tem) / (1 - pow(1 + $tem, -$cuotas))
                : $montoSolicitado / $cuotas;
            $cuotaDeudaActual = $deudaActual > 0 ? $deudaActual / 12 : 0;
            $rds = round((($cuotaEstimada + $cuotaDeudaActual) / $ingresoMensual) * 100, 1);
            $rdsNivel = match(true) {
                $rds <= 30 => 'BAJO',
                $rds <= 40 => 'MEDIO',
                default    => 'ALTO',
            };
            $rdsColor = match($rdsNivel) {
                'BAJO'  => 'verde',
                'MEDIO' => 'amarillo',
                'ALTO'  => 'rojo',
            };
        }
        return [
            'ingreso_mensual'   => $ingresoMensual,
            'deuda_actual'      => $deudaActual,
            'max_dias_atraso'   => $maxDiasAtraso,
            'creditos_castigados' => $creditosCastig,
            'score'             => $score,
            'score_nivel'       => $scoreNivel,
            'score_color'       => $scoreColor,
            'cuota_estimada'    => round($cuotaEstimada, 2),
            'rds'               => $rds,
            'rds_nivel'         => $rdsNivel,
            'rds_color'         => $rdsColor,
        ];
    }

    private function obtenerNivelAprobacion(float $monto): ?object
    {
        return DB::table('dnivelaprobacion')
            ->where('montominimo', '<=', $monto)
            ->where('montomaximo', '>=', $monto)
            ->first();
    }

    public function buscarCliente(Request $request)
    {
        if (!Session::has('usuario_logeado') || Session::get('usuario_rol') !== 'asesor') {
            return response()->json(['success' => false, 'message' => 'Acceso denegado.'], 403);
        }
        $tipoDoc  = $request->query('tipo_doc');
        $documento = $request->query('documento');
        if (empty($tipoDoc) || empty($documento)) {
            return response()->json(['success' => false, 'message' => 'Tipo y número de documento son obligatorios.']);
        }
        $docMapping = [
            'DNI' => 'DNI',
            'CE'  => 'Carnet de Extranjería',
            'RUC' => 'RUC',
            'PAS' => 'Pasaporte',
        ];
        $dbTipoDoc = $docMapping[strtoupper($tipoDoc)] ?? $tipoDoc;
        $cliente = DB::table('dcliente')
            ->where('numerodocumentoidentidad', $documento)
            ->where('destipodocumentoidentidad', $dbTipoDoc)
            ->select('pkcliente', 'nomcliente', 'destipodocumentoidentidad', 'numerodocumentoidentidad')
            ->first();
        if (!$cliente) {
            return response()->json([
                'success' => false,
                'message' => 'No existe ningún cliente registrado con el ' . $tipoDoc . ' ' . $documento . '.',
            ]);
        }
        $solicitudes = DB::table('dsolicitud')
            ->join('dproducto', 'dsolicitud.pkproducto', '=', 'dproducto.pkproducto')
            ->join('dsolicitudestado', 'dsolicitud.pksolicitudestado', '=', 'dsolicitudestado.pksolicitudestado')
            ->where('dsolicitud.pkcliente', $cliente->pkcliente)
            ->where('dsolicitud.pksolicitudestado', 1)
            ->select(
                'dsolicitud.codsolicitud',
                'dsolicitud.montosolicitudcredito as monto',
                'dsolicitud.nrocuotasolicitud as cuotas',
                'dsolicitud.fechasolicitudcredito as fecha',
                'dproducto.desproducto as producto',
                'dsolicitudestado.dessolicitudestado as estado'
            )
            ->get();
        $montoRef = $solicitudes->first()->monto ?? 0;
        $cuotasRef = $solicitudes->first()->cuotas ?? 12;
        $evaluacion = null;
        try {
            $evaluacion = $this->evaluarClientePrivado($cliente->pkcliente, (float) $montoRef, (int) $cuotasRef);
        } catch (\Throwable $e) {
            // Si la evaluación falla (columna faltante, etc.) se omite sin romper la búsqueda
        }
        return response()->json([
            'success' => true,
            'cliente' => [
                'nombre'        => $cliente->nomcliente,
                'documento'     => $cliente->numerodocumentoidentidad,
                'tipo_documento'=> $cliente->destipodocumentoidentidad,
            ],
            'solicitudes' => $solicitudes,
            'evaluacion'  => $evaluacion,
        ]);
    }

    public function registrarSolicitud(Request $request)
    {
        if (!Session::has('usuario_logeado') || Session::get('usuario_rol') !== 'asesor') {
            return response()->json(['success' => false, 'message' => 'Acceso denegado.'], 403);
        }
        $codsolicitud = $request->input('codsolicitud');
        $monto        = (float) $request->input('monto');
        $cuotas       = (int)   $request->input('cuotas');
        $tasa         = (float) $request->input('tasa', 33.06);
        $sol = DB::table('dsolicitud')->where('codsolicitud', $codsolicitud)->first();
        if (!$sol) {
            return response()->json(['success' => false, 'message' => 'Solicitud no encontrada.']);
        }
        $evaluacion = $this->evaluarClientePrivado($sol->pkcliente, $monto, $cuotas, $tasa);
        if ($evaluacion['creditos_castigados'] > 0) {
            return response()->json([
                'success' => false,
                'message' => 'El cliente tiene créditos castigados en su historial. No es elegible para un nuevo crédito (regla de elegibilidad).',
            ]);
        }
$nivel = $this->obtenerNivelAprobacion($monto);
        DB::table('dsolicitud')->where('codsolicitud', $codsolicitud)->update([
            'pksolicitudestado'           => 6,
            'pkasesor'                    => $this->resolverAsesor(),
            'montosolicitudcredito'       => $monto,
            'nrocuotasolicitud'           => $cuotas,
            'plazosolicitudcredito'       => $cuotas * 30,
            'tasainterescompensatoria'    => $tasa,
            'pknivelaprobacion'           => $nivel->pknivelaprobacion ?? null,
            'fechahoraultmodificacion'    => now(),
            'fecultactualizacion'         => now(),
        ]);
        return response()->json([
            'success' => true,
            'message' => 'Solicitud enviada a comité correctamente.',
            'evaluacion' => $evaluacion,
            'nivel_aprobacion' => $nivel->desnivelaprobacion ?? 'No determinado',
        ]);
    }

    public function aprobarSolicitud(Request $request)
    {
        $rolesPermitidos = ['administrador', 'gerencia'];
        if (!Session::has('usuario_logeado') || !in_array(Session::get('usuario_rol'), $rolesPermitidos, true)) {
            return response()->json(['success' => false, 'message' => 'Acceso denegado.'], 403);
        }
        $codsolicitud = $request->input('codsolicitud');
        $sol = DB::table('dsolicitud')
            ->leftJoin('dnivelaprobacion', 'dsolicitud.pknivelaprobacion', '=', 'dnivelaprobacion.pknivelaprobacion')
            ->where('dsolicitud.codsolicitud', $codsolicitud)
            ->select('dsolicitud.*', 'dnivelaprobacion.desnivelaprobacion', 'dnivelaprobacion.codnivelaprobacion')
            ->first();
        if (!$sol) {
            return response()->json(['success' => false, 'message' => 'Solicitud no encontrada.']);
        }
        DB::table('dsolicitud')->where('codsolicitud', $codsolicitud)->update([
            'pksolicitudestado'        => 2,
            'montoaprobadocredito'     => $sol->montosolicitudcredito,
            'nrocuotaaprobado'         => $sol->nrocuotasolicitud,
            'plazoaprobadocredito'     => $sol->plazosolicitudcredito,
            'fechaaprobacioncredito'   => now()->toDateString(),
            'fechahoraultmodificacion' => now(),
            'fecultactualizacion'      => now(),
        ]);
        return response()->json([
            'success' => true,
            'message' => 'Solicitud aprobada correctamente (Nivel: ' . ($sol->desnivelaprobacion ?? 'No determinado') . ').',
        ]);
    }

    public function desembolsarSolicitud(Request $request)
    {
        if (!Session::has('usuario_logeado') || Session::get('usuario_rol') !== 'asesor') {
            return response()->json(['success' => false, 'message' => 'Acceso denegado.'], 403);
        }
        $codsolicitud = $request->input('codsolicitud');
        $sol = DB::table('dsolicitud')
            ->join('dcliente', 'dsolicitud.pkcliente', '=', 'dcliente.pkcliente')
            ->where('dsolicitud.codsolicitud', $codsolicitud)
            ->select('dsolicitud.*', 'dcliente.nomcliente')
            ->first();
        if (!$sol) {
            return response()->json(['success' => false, 'message' => 'Solicitud no encontrada.']);
        }
        $monto  = (float) ($sol->montoaprobadocredito ?? $sol->montosolicitudcredito);
        $cuotas = (int)   ($sol->nrocuotaaprobado     ?? $sol->nrocuotasolicitud);
        $tasa   = (float) ($sol->tasainterescompensatoria ?? 33.06);
        DB::beginTransaction();
        try {
            DB::table('dsolicitud')->where('codsolicitud', $codsolicitud)->update([
                'pksolicitudestado'        => 4,
                'fechahoraultmodificacion' => now(),
                'fecultactualizacion'      => now(),
            ]);
            $cuentaAhorro = DB::table('dcuentaahorro')
                ->where('pkcliente', $sol->pkcliente)
                ->orderBy('pkcuentaahorro')
                ->first();
            if (!$cuentaAhorro) {
                $codAhorro = 'AH' . str_pad($sol->pkcliente, 8, '0', STR_PAD_LEFT) . '-001';
                $pkAhorro  = DB::table('dcuentaahorro')->insertGetId([
                    'codcuentaahorro'     => $codAhorro,
                    'pkcliente'           => $sol->pkcliente,
                    'fecultactualizacion' => now(),
                ], 'pkcuentaahorro');
            } else {
                $pkAhorro = $cuentaAhorro->pkcuentaahorro;
            }
            $hoy = (int) date('Ymd');
            $existeAhorro = DB::table('fcuentaahorro')
                ->where('periododia', $hoy)
                ->where('pkcuentaahorro', $pkAhorro)
                ->exists();
            $saldoActual = DB::table('fcuentaahorro')
                ->where('pkcuentaahorro', $pkAhorro)
                ->max('montosaldocapitaltotal') ?? 0;
            $nuevoSaldo = (float) $saldoActual + $monto;
            $pkProdAhorro = DB::table('dproductoahorro')
                ->where('codtipoproducto', 'AC')
                ->value('pkproductoahorro') ?? 1;
            $pkEstadoCuenta = DB::table('destadocuenta')
                ->where('codestadocuenta', '01')
                ->value('pkestadocuenta') ?? 1;
            $pkTipoCuentaAhorro = DB::table('dtipocuentaahorro')
                ->value('pktipocuentaahorro') ?? 1;
            if (!$existeAhorro) {
                $apertura = DB::table('fcuentaahorro')
                    ->where('pkcuentaahorro', $pkAhorro)
                    ->min('fechaaperturacuenta') ?? now()->toDateString();
                DB::table('fcuentaahorro')->insert([
                    'periododia'                => $hoy,
                    'pkcuentaahorro'            => $pkAhorro,
                    'pkproductoahorro'          => $pkProdAhorro,
                    'pkmoneda'                  => 1,
                    'pktipocuentaahorro'        => $pkTipoCuentaAhorro,
                    'pkcliente'                 => $sol->pkcliente,
                    'pkagencia'                 => $sol->pkagencia,
                    'pkestadocuenta'            => $pkEstadoCuenta,
                    'tipocambio'                => 1,
                    'montosaldocapitaltotal'    => $nuevoSaldo,
                    'montosaldointerestotal'    => 0,
                    'montosaldopromediototal'   => $nuevoSaldo,
                    'fechaaperturacuenta'       => $apertura,
                    'montodepositoapertura'     => $monto,
                    'tasainterescuenta'         => 0.005,
                    'tasaefectivaanual'         => 0.005,
                    'nrotitulares'              => 1,
                    'nrofirmas'                 => 1,
                    'flagexoneracionimpuesto'   => 'N',
                    'flagexoneracioncomision'   => 'N',
                    'flagcuentapromocion'       => 'N',
                    'nrooperacioneslibres'      => 0,
                    'flag_ac'                   => 'S',
                    'montosaldodisponible_ac'   => $nuevoSaldo,
                    'montosaldominimo_ac'       => 0,
                    'fecultactualizacion'       => now(),
                ]);
            } else {
                DB::table('fcuentaahorro')
                    ->where('periododia', $hoy)
                    ->where('pkcuentaahorro', $pkAhorro)
                    ->update([
                        'montosaldocapitaltotal'  => $nuevoSaldo,
                        'montosaldopromediototal' => $nuevoSaldo,
                        'montosaldodisponible_ac' => $nuevoSaldo,
                        'fecultactualizacion'     => now(),
                    ]);
            }
            $nroCuenta = 'CR' . str_pad($sol->pkcliente, 6, '0', STR_PAD_LEFT)
                       . '-' . str_pad($sol->pksolicitud, 4, '0', STR_PAD_LEFT);
            $pkCuentaCredito = DB::table('dcuentacredito')->insertGetId([
                'codcuentacredito'    => $nroCuenta,
                'pkcliente'           => $sol->pkcliente,
                'nrocronograma'       => 1,
                'fecultactualizacion' => now(),
            ], 'pkcuentacredito');
            $periodo = (int) date('Ym');
            $pkEstadoCredito = DB::table('destadocredito')
                ->orderBy('pkestadocredito')
                ->value('pkestadocredito') ?? 1;
            $pkModalidad = DB::table('dmodalidad')
                ->where('codmodalidad', '01')
                ->value('pkmodalidad') ?? 1;
            $pkGrupo = DB::table('dgrupocredito')
                ->orderBy('pkgrupocredito')
                ->value('pkgrupocredito') ?? 1;
            $pkCal = DB::table('dcalificacioncrediticia')
                ->where('codcalificacioncrediticia', '00')
                ->value('pkcalificacioncrediticia') ?? 1;
            $tasaAnual   = $tasa / 100;
            $tasaMensual = pow(1 + $tasaAnual, 1 / 12) - 1;
            $tasaMoratoria = $tasaAnual * 1.5;
            $cuotaFija = $cuotas > 0
                ? $monto * ($tasaMensual * pow(1 + $tasaMensual, $cuotas)) / (pow(1 + $tasaMensual, $cuotas) - 1)
                : $monto;
            $interesTotal = $cuotaFija * $cuotas - $monto;
            DB::table('fagcuentacredito')->insert([
                'periodomes'                     => $periodo,
                'pkcuentacredito'                => $pkCuentaCredito,
                'pksolicitud'                    => $sol->pksolicitud,
                'pkestadocredito'                => $pkEstadoCredito,
                'nrocuotas'                      => $cuotas,
                'nrodias'                        => $cuotas * 30,
                'nrodiasgracias'                 => 0,
                'codtipocuota'                   => 'FC',
                'codtipoperiodo'                 => 'ME',
                'flaglibreamortizacion'          => 'N',
                'montoaprobadocredito'           => $monto,
                'montocapitaldesembolsado'       => $monto,
                'montocapitalpagado'             => 0,
                'montointeresprogramado'         => round($interesTotal, 4),
                'montointeresalafecha'           => 0,
                'montointerespagado'             => 0,
                'montomoraprogramada'            => 0,
                'montomorapagada'                => 0,
                'montogastoprogramado'           => 0,
                'montogastopagado'               => 0,
                'pkproducto'                     => $sol->pkproducto,
                'pkmoneda'                       => $sol->pkmoneda,
                'pkmodalidad'                    => $pkModalidad,
                'tasainterescompensatoria'       => $tasa,
                'tasainteresmoratoria'           => round($tasaMoratoria * 100, 6),
                'diasatrasocredito'              => 0,
                'fechadesembolsocredito'         => now()->toDateString(),
                'tipocambiodesembolso'           => 1,
                'pkgrupocredito'                 => $pkGrupo,
                'flagrefinanciado'               => 'N',
                'flagreestructurado'             => 'N',
                'flagreprogramado'               => 'N',
                'flagjudicial'                   => 'N',
                'flagcastigado'                  => 'N',
                'montosaldonormal'               => $monto,
                'montosaldovencido'              => 0,
                'pkcliente'                      => $sol->pkcliente,
                'nrocronograma'                  => 1,
                'pkcalificacioncrediticiainterna'=> $pkCal,
                'pkcalificacioncrediticiaexterna'=> $pkCal,
                'flagclientenuevobancoandino'    => 'S',
                'flagclientenuevo'               => 'S',
                'flagclientecartera'             => 'S',
                'montosaldocapital'              => $monto,
                'montosaldointeres'              => round($interesTotal, 4),
                'montosaldomoratorio'            => 0,
                'montosaldogasto'                => 0,
                'car_vig_capital'                => $monto,
                'car_vig_int_compensatorio'      => round($interesTotal, 4),
                'car_vig_int_moratorio'          => 0,
                'car_vig_gastos'                 => 0,
                'car_ven_capital'                => 0,
                'car_ven_int_compensatorio'      => 0,
                'car_ven_int_moratorio'          => 0,
                'car_ven_gastos'                 => 0,
                'car_ref_capital'                => 0,
                'car_ref_int_compensatorio'      => 0,
                'car_ref_int_moratorio'          => 0,
                'car_ref_gastos'                 => 0,
                'car_rep_capital'                => 0,
                'car_rep_int_compensatorio'      => 0,
                'car_rep_int_moratorio'          => 0,
                'car_rep_gastos'                 => 0,
                'car_jud_capital'                => 0,
                'car_jud_int_compensatorio'      => 0,
                'car_jud_int_moratorio'          => 0,
                'car_jud_gastos'                 => 0,
                'car_cas_capital'                => 0,
                'car_cas_int_compensatorio'      => 0,
                'car_cas_int_moratorio'          => 0,
                'car_cas_gastos'                 => 0,
                'car_con_capital'                => 0,
                'car_con_int_compensatorio'      => 0,
                'car_con_int_moratorio'          => 0,
                'car_con_gastos'                 => 0,
                'saldodiferido'                  => 0,
                'saldodevengado'                 => round($interesTotal, 4),
                'saldoprovisiones'               => 0,
                'montosaldocliente'              => $monto,
                'montocapitalpagado'             => 0,
                'montocapitalinicio'             => $monto,
                'montointeresinicio'             => round($interesTotal, 4),
                'montomorainicio'                => 0,
                'montogastoinicio'               => 0,
                'nrodiasatrasoinicio'            => 0,
                'pkagencia'                      => $sol->pkagencia,
                'pkasesor'                       => $sol->pkasesor,
                'fecultactualizacion'            => now(),
            ]);
            $saldoCap = $monto;
            $fechaBase = now();
            for ($n = 1; $n <= $cuotas; $n++) {
                $interesCuota   = round($saldoCap * $tasaMensual, 4);
                $capitalCuota   = round($cuotaFija - $interesCuota, 4);
                if ($n === $cuotas) {
                    $capitalCuota = round($saldoCap, 4);
                }
                $saldoCap -= $capitalCuota;
                if (abs($saldoCap) < 0.01) {
                    $saldoCap = 0;
                }
                $fechaVenc  = $fechaBase->copy()->addMonths($n);
                $periodoMes = (int) $fechaVenc->format('Ym');
                $existePeriodo = DB::table('dtiempomes')->where('periodomes', $periodoMes)->exists();
                if (!$existePeriodo) {
                    DB::table('dtiempomes')->insert([
                        'periodomes'         => $periodoMes,
                        'mes'                => (int) $fechaVenc->format('m'),
                        'anio'               => (int) $fechaVenc->format('Y'),
                        'descripcionmes'     => $fechaVenc->format('Y-m'),
                        'bimestre'           => (int) ceil($fechaVenc->format('m') / 2),
                        'trimestre'          => (int) ceil($fechaVenc->format('m') / 3),
                        'cuatrimestre'       => (int) ceil($fechaVenc->format('m') / 4),
                        'semestre'           => $fechaVenc->format('m') <= 6 ? 1 : 2,
                        'fecultactualizacion'=> now(),
                    ]);
                }
                $codPlan = $nroCuenta . '-' . str_pad($n, 3, '0', STR_PAD_LEFT);
                DB::table('fplanpagomes')->insert([
                    'periodomes'                 => $periodoMes,
                    'pkcuentacredito'            => $pkCuentaCredito,
                    'codplanpago'                => $codPlan,
                    'nrocuota'                   => $n,
                    'pksolicitud'                => $sol->pksolicitud,
                    'pkestadocredito'            => $pkEstadoCredito,
                    'pkproducto'                 => $sol->pkproducto,
                    'pkmoneda'                   => $sol->pkmoneda,
                    'pkmodalidad'                => $pkModalidad,
                    'pkgrupocredito'             => $pkGrupo,
                    'pkcliente'                  => $sol->pkcliente,
                    'pkcalificacioncrediticiainterna' => $pkCal,
                    'pkagencia'                  => $sol->pkagencia,
                    'pkasesor'                   => $sol->pkasesor,
                    'codestadocuota'             => 'PE',
                    'fechavencimientopagocuota'  => $fechaVenc->toDateString(),
                    'montocuota'                 => round($cuotaFija, 4),
                    'montosaldo'                 => round(max($saldoCap, 0), 4),
                    'montomora'                  => 0,
                    'montocuotavencida'          => 0,
                    'montocuotaatrasada'         => 0,
                    'montointeresprogramado'     => $interesCuota,
                    'montointerespagado'         => 0,
                    'montointeresalafecha'       => 0,
                    'montomoraprogramado'        => 0,
                    'montomorapagada'            => 0,
                    'montogasto'                 => 0,
                    'montogastoprogramado'       => 0,
                    'montogastopagado'           => 0,
                    'montosaldocapital'          => round(max($saldoCap + $capitalCuota, 0), 4),
                    'montocapitalpagado'         => 0,
                    'montocapitalprogramado'     => $capitalCuota,
                    'montocapitaldesembolsado'   => $monto,
                    'diasatrasocuota'            => 0,
                    'diasvencidocuota'           => 0,
                    'interesdevengadocuota'      => 0,
                    'montopagoanticipado'        => 0,
                    'montopagoparcial'           => 0,
                    'fecultactualizacion'        => now(),
                ]);
            }
            DB::commit();
            return response()->json([
                'success'        => true,
                'message'        => 'Crédito desembolsado exitosamente. Cuenta creada y cronograma generado.',
                'cod_cuenta'     => $nroCuenta,
                'cuotas_generadas' => $cuotas,
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Error al desembolsar: ' . $e->getMessage()]);
        }
    }

    public function evaluarCliente(Request $request)
    {
        if (!Session::has('usuario_logeado') || Session::get('usuario_rol') !== 'asesor') {
            return response()->json(['success' => false, 'message' => 'Acceso denegado.'], 403);
        }
        $codsolicitud = $request->query('codsolicitud');
        $montoNuevo   = (float) $request->query('monto', 0);
        $cuotasNuevo  = (int)   $request->query('cuotas', 12);
        $tasaNuevo    = (float) $request->query('tasa', 33.06);
        $sol = DB::table('dsolicitud')
            ->join('dcliente', 'dsolicitud.pkcliente', '=', 'dcliente.pkcliente')
            ->where('dsolicitud.codsolicitud', $codsolicitud)
            ->select(
                'dcliente.pkcliente',
                'dcliente.nomcliente',
                'dcliente.montodeingreso',
                'dcliente.fechaingresocaja'
            )
            ->first();
        if (!$sol) {
            return response()->json(['success' => false, 'message' => 'Solicitud no encontrada.']);
        }
        $pkcliente     = $sol->pkcliente;
        $ingreso       = (float) ($sol->montodeingreso ?? 0);
        $ultimoPeriodo = DB::table('fagcuentacredito')->max('periodomes') ?? 202512;
        $calificacion = DB::table('fagcuentacredito')
            ->join('dcalificacioncrediticia',
                   'fagcuentacredito.pkcalificacioncrediticiainterna', '=',
                   'dcalificacioncrediticia.pkcalificacioncrediticia')
            ->where('fagcuentacredito.pkcliente', $pkcliente)
            ->where('fagcuentacredito.periodomes', $ultimoPeriodo)
            ->orderByRaw("CASE dcalificacioncrediticia.codcalificacioncrediticia
                WHEN 'N1' THEN 1 WHEN 'N2' THEN 2 WHEN 'N3' THEN 3
                WHEN 'N4' THEN 4 WHEN 'N5' THEN 5 ELSE 6 END")
            ->select('dcalificacioncrediticia.codcalificacioncrediticia as cod',
                     'dcalificacioncrediticia.descalificacioncrediticia as label')
            ->first();
        $ptsHistorial = match($calificacion?->cod ?? 'SIN') {
            'N1' => 40, 'N2' => 30, 'N3' => 15, 'N4' => 5,
            'SIN' => 25,
            default => 0,
        };
        $labelHistorial = $calificacion?->label ?? 'Sin historial en el sistema';
        $maxAtraso = DB::table('fagcuentacredito')
            ->where('pkcliente', $pkcliente)
            ->where('periodomes', $ultimoPeriodo)
            ->max('diasatrasocredito') ?? 0;
        $ptsAtraso = match(true) {
            $maxAtraso === 0        => 30,
            $maxAtraso <= 15        => 20,
            $maxAtraso <= 30        => 10,
            $maxAtraso <= 60        => 5,
            default                 => 0,
        };
        $aniosCliente = 0;
        if ($sol->fechaingresocaja) {
            $aniosCliente = (int) now()->diffInYears(\Carbon\Carbon::parse($sol->fechaingresocaja));
        }
        $ptsAntiguedad = match(true) {
            $aniosCliente >= 5  => 20,
            $aniosCliente >= 3  => 15,
            $aniosCliente >= 1  => 10,
            default             => 5,
        };
        $creditosActivos = DB::table('fagcuentacredito')
            ->where('pkcliente', $pkcliente)
            ->where('periodomes', $ultimoPeriodo)
            ->where('diasatrasocredito', 0)
            ->count();
        $ptsCreditosActivos = $creditosActivos > 0 ? 10 : 5;
        $scoringTotal = $ptsHistorial + $ptsAtraso + $ptsAntiguedad + $ptsCreditosActivos;
        $scoringTotal = min(100, max(0, $scoringTotal));
        $scoringColor  = $scoringTotal >= 70 ? 'verde' : ($scoringTotal >= 50 ? 'amarillo' : 'rojo');
        $scoringLabel  = $scoringTotal >= 70 ? 'Riesgo bajo'
                       : ($scoringTotal >= 50 ? 'Riesgo medio' : 'Riesgo alto');
        $tasaMensual  = pow(1 + $tasaNuevo / 100, 1 / 12) - 1;
        $cuotaNueva   = $cuotasNuevo > 0 && $montoNuevo > 0
            ? $montoNuevo * ($tasaMensual * pow(1 + $tasaMensual, $cuotasNuevo))
              / (pow(1 + $tasaMensual, $cuotasNuevo) - 1)
            : 0;
        $deudaMensualExistente = DB::table('fplanpagomes')
            ->where('pkcliente', $pkcliente)
            ->where('periodomes', $ultimoPeriodo)
            ->where('codestadocuota', 'PE')
            ->avg('montocuota') ?? 0;
        $totalServicio = round($cuotaNueva + (float) $deudaMensualExistente, 2);
        $rds = $ingreso > 0 ? round(($totalServicio / $ingreso) * 100, 1) : 0;
        $rdsColor = $rds <= 30 ? 'verde' : ($rds <= 40 ? 'amarillo' : 'rojo');
        $rdsLabel = match(true) {
            $rds <= 30 => 'Capacidad de pago adecuada',
            $rds <= 40 => 'Capacidad de pago en límite',
            $rds > 40  => 'Capacidad de pago insuficiente',
            default    => '—',
        };
        $elegible = true;
        $motivosRechazo = [];
        if ($maxAtraso > 90) {
            $elegible = false;
            $motivosRechazo[] = 'Cliente con más de 90 días de atraso en créditos activos.';
        }
        if ($scoringTotal < 30) {
            $elegible = false;
            $motivosRechazo[] = 'Scoring crediticio por debajo del mínimo requerido (30 pts).';
        }
        if ($rds > 60 && $ingreso > 0) {
            $elegible = false;
            $motivosRechazo[] = 'RDS supera el 60%: riesgo de sobreendeudamiento.';
        }
        $rutaAprobacion = match(true) {
            $montoNuevo <= 10000   => ['nivel'=>'N1','label'=>'Asesor de Negocios',           'icono'=>'fa-user-tie'],
            $montoNuevo <= 50000   => ['nivel'=>'N2','label'=>'Administrador de Agencia',      'icono'=>'fa-building-user'],
            $montoNuevo <= 150000  => ['nivel'=>'N3','label'=>'Jefe de Negocios Regional',     'icono'=>'fa-user-shield'],
            $montoNuevo <= 500000  => ['nivel'=>'N4','label'=>'Comité de Créditos de Agencia', 'icono'=>'fa-users'],
            $montoNuevo <= 1500000 => ['nivel'=>'N5','label'=>'Comité de Créditos Central',    'icono'=>'fa-landmark'],
            default                => ['nivel'=>'N6','label'=>'Directorio',                    'icono'=>'fa-crown'],
        };
        return response()->json([
            'success'   => true,
            'cliente'   => $sol->nomcliente,
            'ingreso'   => $ingreso,
            'scoring'   => [
                'total'      => $scoringTotal,
                'color'      => $scoringColor,
                'label'      => $scoringLabel,
                'historial'  => $labelHistorial,
                'atraso_max' => $maxAtraso,
                'antiguedad' => $aniosCliente,
                'desglose'   => [
                    'historial'  => $ptsHistorial,
                    'atraso'     => $ptsAtraso,
                    'antiguedad' => $ptsAntiguedad,
                    'activos'    => $ptsCreditosActivos,
                ],
            ],
            'rds' => [
                'porcentaje'  => $rds,
                'color'       => $rdsColor,
                'label'       => $rdsLabel,
                'cuota_nueva' => round($cuotaNueva, 2),
                'deuda_exist' => round((float)$deudaMensualExistente, 2),
                'total_serv'  => $totalServicio,
                'ingreso'     => $ingreso,
            ],
            'elegibilidad' => [
                'elegible'         => $elegible,
                'motivos_rechazo'  => $motivosRechazo,
            ],
            'ruta_aprobacion' => $rutaAprobacion,
        ]);
    }

    public function registrarGestion(Request $request)
    {
        if (!Session::has('usuario_logeado') || Session::get('usuario_rol') !== 'asesor') {
            return response()->json(['success' => false, 'message' => 'Sin autorización.'], 403);
        }
        $request->validate([
            'pkcuentacredito' => 'required|integer',
            'pktipogestion'   => 'required|integer',
            'resultado'       => 'required|string|max:120',
        ]);
        $ultimoPeriodo = DB::table('fagcuentacredito')->max('periodomes') ?? 202512;
        $credito = DB::table('fagcuentacredito')
            ->where('pkcuentacredito', $request->pkcuentacredito)
            ->where('periodomes', $ultimoPeriodo)
            ->select('diasatrasocredito', 'flagjudicial', 'flagcastigado')
            ->first();
        if (!$credito) {
            return response()->json(['success' => false, 'message' => 'Crédito no encontrado.']);
        }
        $dias = $credito->diasatrasocredito;
        $banda = match(true) {
            ($credito->flagcastigado === 'S' || $dias > 180) => 'CASTIGO',
            ($credito->flagjudicial  === 'S' || $dias > 120) => 'JUDICIAL',
            $dias > 60  => 'TARDÍA',
            $dias > 30  => 'TEMPRANA',
            default     => 'PREVENTIVA',
        };
        DB::table('fgestioncobranza')->insert([
            'pkcuentacredito'     => $request->pkcuentacredito,
            'pktipogestion'       => $request->pktipogestion,
            'fechagestion'        => now()->toDateString(),
            'diasatrasoalmomento' => $dias,
            'banda'               => $banda,
            'gestor'              => Session::get('usuario_logeado'),
            'resultado'           => $request->resultado,
            'compromisopago'      => $request->compromisopago ?: null,
            'montocomprometido'   => $request->montocomprometido ?: null,
            'fecultactualizacion' => now(),
        ]);
        return response()->json(['success' => true, 'message' => 'Gestión registrada correctamente.', 'banda' => $banda]);
    }

    public function derivarJudicial(Request $request)
    {
        $rolesPermitidos = ['riesgos', 'gerencia'];
        if (!Session::has('usuario_logeado') || !in_array(Session::get('usuario_rol'), $rolesPermitidos, true)) {
            return response()->json(['success' => false, 'message' => 'Sin autorización.'], 403);
        }
        $request->validate(['pkcuentacredito' => 'required|integer']);
        $ultimoPeriodo = DB::table('fagcuentacredito')->max('periodomes') ?? 202512;
        $credito = DB::table('fagcuentacredito')
            ->where('pkcuentacredito', $request->pkcuentacredito)
            ->where('periodomes', $ultimoPeriodo)
            ->select('diasatrasocredito', 'flagjudicial')
            ->first();
        if (!$credito) {
            return response()->json(['success' => false, 'message' => 'Crédito no encontrado.']);
        }
        if ($credito->diasatrasocredito < 121) {
            return response()->json(['success' => false, 'message' => 'El crédito debe tener al menos 121 días de atraso para derivarse a judicial.']);
        }
        if ($credito->flagjudicial === 'S') {
            return response()->json(['success' => false, 'message' => 'El crédito ya está en estado judicial.']);
        }
        DB::table('fagcuentacredito')
            ->where('pkcuentacredito', $request->pkcuentacredito)
            ->where('periodomes', $ultimoPeriodo)
            ->update([
                'flagjudicial'        => 'S',
                'fechaingresojudicial' => now()->toDateString(),
                'fecultactualizacion' => now(),
            ]);
        $pkTipoJudicial = DB::table('dtipogestioncobranza')
            ->where('codtipogestion', 'JUDI')->value('pktipogestion');
        if ($pkTipoJudicial) {
            DB::table('fgestioncobranza')->insert([
                'pkcuentacredito'     => $request->pkcuentacredito,
                'pktipogestion'       => $pkTipoJudicial,
                'fechagestion'        => now()->toDateString(),
                'diasatrasoalmomento' => $credito->diasatrasocredito,
                'banda'               => 'JUDICIAL',
                'gestor'              => Session::get('usuario_logeado'),
                'resultado'           => 'Crédito derivado a cobranza judicial por sistema.',
                'fecultactualizacion' => now(),
            ]);
        }
        return response()->json(['success' => true, 'message' => 'Crédito derivado a cobranza judicial correctamente.']);
    }

    public function castigarCredito(Request $request)
    {
        $rolesPermitidos = ['riesgos', 'gerencia'];
        if (!Session::has('usuario_logeado') || !in_array(Session::get('usuario_rol'), $rolesPermitidos, true)) {
            return response()->json(['success' => false, 'message' => 'Sin autorización.'], 403);
        }
        $request->validate(['pkcuentacredito' => 'required|integer']);
        $ultimoPeriodo = DB::table('fagcuentacredito')->max('periodomes') ?? 202512;
        $credito = DB::table('fagcuentacredito')
            ->where('pkcuentacredito', $request->pkcuentacredito)
            ->where('periodomes', $ultimoPeriodo)
            ->select('diasatrasocredito', 'flagcastigado')
            ->first();
        if (!$credito) {
            return response()->json(['success' => false, 'message' => 'Crédito no encontrado.']);
        }
        if ($credito->diasatrasocredito <= 180) {
            return response()->json(['success' => false, 'message' => 'El crédito debe tener más de 180 días de atraso para ser castigado.']);
        }
        if ($credito->flagcastigado === 'S') {
            return response()->json(['success' => false, 'message' => 'El crédito ya está castigado.']);
        }
        DB::table('fagcuentacredito')
            ->where('pkcuentacredito', $request->pkcuentacredito)
            ->where('periodomes', $ultimoPeriodo)
            ->update([
                'flagcastigado'       => 'S',
                'fecultactualizacion' => now(),
            ]);
        $pkTipoJudicial = DB::table('dtipogestioncobranza')
            ->where('codtipogestion', 'JUDI')->value('pktipogestion');
        if ($pkTipoJudicial) {
            DB::table('fgestioncobranza')->insert([
                'pkcuentacredito'     => $request->pkcuentacredito,
                'pktipogestion'       => $pkTipoJudicial,
                'fechagestion'        => now()->toDateString(),
                'diasatrasoalmomento' => $credito->diasatrasocredito,
                'banda'               => 'CASTIGO',
                'gestor'              => Session::get('usuario_logeado'),
                'resultado'           => 'Crédito castigado por sistema (>180 días de atraso).',
                'fecultactualizacion' => now(),
            ]);
        }
        return response()->json(['success' => true, 'message' => 'Crédito castigado correctamente.']);
    }
}