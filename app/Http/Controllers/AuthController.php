<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // =========================================================
    // LOGIN — intenta primero como CLIENTE (homebanking),
    // si no existe ahí, intenta como EMPLEADO (core financiero).
    // El rol YA NO viene del formulario: se determina aquí,
    // según en qué tabla se valida el usuario.
    // =========================================================
    public function procesarLogin(Request $request)
    {
        $tipo_doc  = $request->input('tipo_doc');
        $documento = $request->input('documento');
        $password  = $request->input('password');
        $portal    = $request->input('rol', 'cliente'); // 'cliente' o 'asesor', viene del botón que el usuario eligió

        if (empty($documento) || empty($password)) {
            return back()->with('error', 'Documento y contraseña son obligatorios.');
        }

        if ($portal === 'asesor') {
            return $this->loginEmpleado($documento, $password);
        }

        return $this->loginCliente($tipo_doc, $documento, $password);
    }

    private function loginCliente(?string $tipo_doc, string $documento, string $password)
    {
        $docMapping = [
            'DNI'  => 'DNI',
            'CE'   => 'Carnet de Extranjería',
            'RUC'  => 'RUC',
            'PAS'  => 'Pasaporte',
        ];
        $dbTipoDoc = $docMapping[strtoupper($tipo_doc)] ?? $tipo_doc;

        $usuarioCliente = DB::table('usuarios_homebanking')
            ->join('dcliente', 'usuarios_homebanking.pkcliente', '=', 'dcliente.pkcliente')
            ->where('usuarios_homebanking.username', '=', $documento)
            ->where('dcliente.destipodocumentoidentidad', '=', $dbTipoDoc)
            ->select(
                'usuarios_homebanking.pkusuario as id',
                'usuarios_homebanking.password_hash as password',
                'usuarios_homebanking.bloqueado',
                'usuarios_homebanking.activo',
                'dcliente.nomcliente as nombre',
                'dcliente.destipodocumentoidentidad as tipo_documento',
                'dcliente.numerodocumentoidentidad as nro_documento'
            )
            ->first();

        if (!$usuarioCliente) {
            return back()->with('error', 'El tipo, número de documento o la contraseña son incorrectos.');
        }

        if ($usuarioCliente->bloqueado === 'S' || $usuarioCliente->activo === 'N') {
            return back()->with('error', 'Tu cuenta está bloqueada o inactiva. Contacta con el banco.');
        }

        if (!$this->verificarPassword($password, $usuarioCliente->password)) {
            DB::table('usuarios_homebanking')
                ->where('pkusuario', $usuarioCliente->id)
                ->increment('intentos_fallidos');

            return back()->with('error', 'El tipo, número de documento o la contraseña son incorrectos.');
        }

        Session::put('usuario_logeado', $usuarioCliente->id); // pkusuario — clave interna segura
        Session::put('usuario_id', $usuarioCliente->id);
        Session::put('usuario_nombre', $usuarioCliente->nombre);
        Session::put('usuario_rol', 'cliente');

        DB::table('usuarios_homebanking')
            ->where('pkusuario', $usuarioCliente->id)
            ->update(['ultimo_acceso' => now(), 'intentos_fallidos' => 0]);

        return redirect('/dashboard');
    }

    private function loginEmpleado(string $documento, string $password)
    {
        // Regla de negocio indicada por el profesor: el usuario y la
        // contraseña del empleado son su propio DNI. dpersonal no
        // tiene columna de password porque la clave ES el numerodni.
        $empleado = DB::table('dpersonal')
            ->leftJoin('dpersonalcargo', 'dpersonal.pkpersonal', '=', 'dpersonalcargo.pkpersonal')
            ->leftJoin('dcargopersonal', 'dpersonalcargo.pkcargopersonal', '=', 'dcargopersonal.pkcargopersonal')
            ->where('dpersonal.numerodni', '=', $documento)
            ->where('dpersonal.estadopersonal', '=', '1') // solo personal activo
            ->select(
                'dpersonal.pkpersonal',
                'dpersonal.nombre',
                'dpersonal.numerodni',
                'dcargopersonal.codcargopersonal as cod_cargo',
                'dcargopersonal.descargopersonal as cargo'
            )
            ->first();

        if (!$empleado || $documento !== $password) {
            return back()->with('error', 'Documento o contraseña incorrectos para el portal de asesores.');
        }

        $rol = $this->resolverRolPorCargo($empleado->cod_cargo);

        Session::put('usuario_logeado', $empleado->numerodni);
        Session::put('usuario_id', $empleado->pkpersonal);
        Session::put('usuario_nombre', $empleado->nombre);
        Session::put('usuario_rol', $rol);
        Session::put('usuario_cargo', $empleado->cargo);

        return redirect('/dashboard');
    }

    // =========================================================
    // Verifica password contra hash, soportando tanto el formato
    // bcrypt nativo de Laravel ($2y$) como el generado por
    // Postgres pgcrypto ($2a$) — ambos son bcrypt válido.
    // =========================================================
    private function verificarPassword(string $plano, ?string $hash): bool
    {
        if (empty($hash)) {
            return false;
        }
        // password_verify() de PHP soporta $2a$, $2x$ y $2y$ (todos bcrypt válidos).
        // Hash::check() de Laravel 13 rechaza $2a$ (generado por pgcrypto) con
        // RuntimeException, así que usamos password_verify() directo.
        return password_verify($plano, $hash);
    }

    // =========================================================
    // Determina el rol del empleado según su cargo.
    // Por ahora todo cargo no reconocido cae en 'asesor' como
    // valor seguro mínimo (acceso limitado al core de asesor).
    // Los roles administrador/riesgos/comité/gerencia se afinan
    // en el siguiente paso de RBAC.
    // =========================================================
    // =========================================================
    // Mapeo de cargo -> rol del sistema, basado en el catálogo
    // real DCARGOPERSONAL de la BD (no en texto libre, para
    // evitar falsos positivos por coincidencias parciales).
    //
    //   G01 Gerente Central         -> gerencia
    //   G02 Gerente de Área         -> gerencia
    //   F01 Jefe Negocios Regional  -> administrador
    //   F02 Administrador Agencia   -> administrador
    //   F03 Jefe de Operaciones     -> administrador
    //   F04 Jefe de Riesgos         -> riesgos
    //   F05 Funcionario de Créditos -> asesor
    //   E01 Asesor de Negocios      -> asesor
    //   E02-E07 (resto)             -> asesor
    //
    // Nota: "Comité" no es un cargo individual en este modelo de
    // datos (DCOMITE es una entidad colegiada sin miembros
    // vinculados a DPERSONAL), por lo que no existe un rol de
    // login "comite": la resolución en comité ya se maneja como
    // estado de la solicitud (pksolicitudestado = 6), no como un
    // tipo de usuario que inicia sesión.
    // =========================================================
    private function resolverRolPorCargo(?string $codCargo): string
    {
        if (!$codCargo) {
            return 'asesor';
        }

        return match($codCargo) {
            'G01', 'G02'         => 'gerencia',
            'F01', 'F02', 'F03'  => 'administrador',
            'F04'                => 'riesgos',
            default              => 'asesor', // F05, E01-E07
        };
    }

    public function cerrarSesion()
    {
        Session::forget('usuario_logeado');
        Session::forget('usuario_id');
        Session::forget('usuario_nombre');
        Session::forget('usuario_rol');
        Session::forget('usuario_cargo');

        return redirect('/');
    }

    public function procesarRegistro(Request $request)
    {
        $tipo_doc  = $request->tipo_doc ?? 'DNI';
        $documento = $request->documento;
        $nombre    = $request->nombre;
        $password  = $request->password;

        if (empty($documento) || empty($nombre) || empty($password)) {
            return back()->with('error', 'Todos los campos son obligatorios.');
        }

        if (strlen($password) < 6) {
            return back()->with('error', 'La contraseña debe tener al menos 6 caracteres.');
        }

        $docMapping = [
            'DNI'  => ['pk' => 1, 'cod' => '01', 'des' => 'DNI'],
            'CE'   => ['pk' => 2, 'cod' => '04', 'des' => 'Carnet de Extranjería'],
            'RUC'  => ['pk' => 3, 'cod' => '06', 'des' => 'RUC'],
            'PAS'  => ['pk' => 4, 'cod' => '07', 'des' => 'Pasaporte'],
        ];

        $mapping = $docMapping[strtoupper($tipo_doc)] ?? $docMapping['DNI'];

        $cliente = DB::table('dcliente')
            ->where('numerodocumentoidentidad', $documento)
            ->where('destipodocumentoidentidad', $mapping['des'])
            ->first();

        if ($cliente) {
            $pkcliente = $cliente->pkcliente;
        } else {
            $nextPk = (DB::table('dcliente')->max('pkcliente') ?? 0) + 1;
            $codcliente = 'CLI' . str_pad($nextPk, 6, '0', STR_PAD_LEFT);

            $pkcliente = DB::table('dcliente')->insertGetId([
                'codcliente' => $codcliente,
                'nomcliente' => $nombre,
                'pkclasepersona' => 1,
                'codclasepersona' => '01',
                'desclasepersona' => 'Persona Natural',
                'fechaingresocaja' => date('Y-m-d'),
                'pktipodocumentoidentidad' => $mapping['pk'],
                'codtipodocumentoidentidad' => $mapping['cod'],
                'destipodocumentoidentidad' => $mapping['des'],
                'numerodocumentoidentidad' => $documento,
                'fecultactualizacion' => now(),
            ], 'pkcliente');
        }

        $userExists = DB::table('usuarios_homebanking')
            ->where('username', $documento)
            ->exists();

        if ($userExists) {
            return back()->with('error', 'El usuario con este número de documento ya está registrado.');
        }

        DB::table('usuarios_homebanking')->insert([
            'pkcliente' => $pkcliente,
            'username' => $documento,
            'password_hash' => Hash::make($password),
            'intentos_fallidos' => 0,
            'bloqueado' => 'N',
            'activo' => 'S',
            'fecultactualizacion' => now(),
        ]);

        return redirect('/login')->with('success', 'Usuario registrado correctamente.');
    }
}