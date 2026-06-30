<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scotiabank - Core Financiero</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;900&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        body { font-family: 'Inter', sans-serif; }
        @keyframes fadeSlide {
            from { opacity: 0; transform: translateY(10px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .fade-in { animation: fadeSlide .35s ease both; }
        .toast {
            position: fixed; bottom: 24px; right: 24px; z-index: 9999;
            padding: 12px 20px; border-radius: 10px; font-size: 13px;
            font-weight: 600; box-shadow: 0 8px 24px rgba(0,0,0,.2);
            transition: opacity .3s;
        }
        .toast-success { background: #059669; color: white; }
        .toast-error   { background: #dc2626; color: white; }
    </style>
</head>
<body class="bg-zinc-100 min-h-screen flex flex-col">
    @php
        // Matriz de permisos por rol (separación de funciones real):
        //   asesor          -> opera (busca, registra, desembolsa, gestiona cobranza)
        //   administrador   -> aprueba solicitudes (decisión del crédito)
        //   riesgos         -> decide acciones críticas de mora (judicial, castigo)
        //   gerencia        -> autoridad sobre aprobación y sobre cobranza crítica
        // El servidor valida esto de nuevo en cada endpoint (ver middleware
        // 'rol' en routes/web.php) -- esto es solo la capa de UI.
        $puedeAprobar      = in_array(Session::get('usuario_rol'), ['administrador', 'gerencia'], true);
        $puedeDecidirMora  = in_array(Session::get('usuario_rol'), ['riesgos', 'gerencia'], true);
    @endphp

    {{-- TOP NAV --}}
    <nav class="bg-zinc-900 text-white px-6 h-14 flex justify-between items-center shadow-lg border-b-2 border-[#EC111A] sticky top-0 z-50">
        <div class="flex items-center space-x-3">
            <span class="bg-[#EC111A] text-white rounded-full w-8 h-8 flex items-center justify-center text-xl font-serif font-black">S</span>
            <span class="font-black text-xl tracking-tight">Scotiabank</span>
            <span class="text-[10px] bg-[#EC111A]/20 text-red-400 border border-red-500/30 px-2 py-0.5 rounded font-bold tracking-wider uppercase">Core Financiero</span>
        </div>
        <div class="flex items-center space-x-4">
            <div class="flex items-center space-x-2">
                <div class="w-8 h-8 bg-zinc-700 text-zinc-200 rounded-full flex items-center justify-center font-bold text-xs uppercase">
                    {{ strtoupper(substr(Session::get('usuario_nombre', 'AS'), 0, 2)) }}
                </div>
                <div class="text-right hidden sm:block">
                    <p class="text-[10px] text-zinc-500 font-bold uppercase">{{ ucfirst(Session::get('usuario_rol', 'asesor')) }}</p>
                    <p class="text-xs font-semibold text-zinc-200">{{ Session::get('usuario_nombre') }}</p>
                </div>
            </div>
            <a href="/logout" class="bg-zinc-800 hover:bg-zinc-700 transition text-xs font-bold px-3 py-2 rounded-lg text-zinc-400 hover:text-white border border-zinc-700 flex items-center space-x-1.5">
                <i class="fa-solid fa-right-from-bracket text-xs"></i>
                <span>Cerrar sesión</span>
            </a>
        </div>
    </nav>

    <div class="flex flex-1 overflow-hidden">

        {{-- SIDEBAR --}}
        <aside class="w-60 bg-zinc-900 min-h-screen flex flex-col py-6 px-3 space-y-1 border-r border-zinc-800 shrink-0">

            <p class="text-[9px] uppercase font-bold tracking-widest text-zinc-500 px-4 mb-1">Principal</p>

            <a href="#" id="link-dashboard"
               onclick="showSection('dashboard', this)"
               class="flex items-center space-x-3 px-4 py-2.5 rounded-lg text-sm font-semibold text-white bg-[#EC111A]/10 cursor-pointer">
                <i class="fa-solid fa-chart-pie w-4 text-[#EC111A]"></i>
                <span>Dashboard</span>
            </a>

            <p class="text-[9px] uppercase font-bold tracking-widest text-zinc-500 px-4 mt-4 mb-1">Otorgamiento de Créditos</p>

            <a href="#" id="link-bandeja"
               onclick="showSection('bandeja', this)"
               class="flex items-center space-x-3 px-4 py-2.5 rounded-lg text-sm font-medium text-zinc-300 hover:bg-zinc-800 hover:text-white transition-all duration-150 cursor-pointer">
                <i class="fa-solid fa-inbox w-4 text-zinc-400"></i>
                <span>Bandeja de solicitudes</span>
                @if($bandeja->where('estado_id', 1)->count() > 0)
                <span class="ml-auto bg-[#EC111A] text-white text-[9px] font-bold px-1.5 py-0.5 rounded-full">
                    {{ $bandeja->where('estado_id', 1)->count() }}
                </span>
                @endif
            </a>

            <a href="#" id="link-presolicitud"
               onclick="showSection('presolicitud', this)"
               class="flex items-center space-x-3 px-4 py-2.5 rounded-lg text-sm font-medium text-zinc-300 hover:bg-zinc-800 hover:text-white transition-all duration-150 cursor-pointer">
                <i class="fa-solid fa-1 w-4 text-zinc-400"></i>
                <span>1. Pre-solicitud</span>
            </a>

            <a href="#" id="link-registrosolicitud"
               onclick="showSection('registrosolicitud', this)"
               class="flex items-center space-x-3 px-4 py-2.5 rounded-lg text-sm font-medium text-zinc-300 hover:bg-zinc-800 hover:text-white transition-all duration-150 cursor-pointer">
                <i class="fa-solid fa-2 w-4 text-zinc-400"></i>
                <span>2. Registro de solicitud</span>
            </a>

            <a href="#" id="link-propuesta"
               onclick="showSection('propuesta', this)"
               class="flex items-center space-x-3 px-4 py-2.5 rounded-lg text-sm font-medium text-zinc-300 hover:bg-zinc-800 hover:text-white transition-all duration-150 cursor-pointer">
                <i class="fa-solid fa-3 w-4 text-zinc-400"></i>
                <span>3. Propuesta y comité</span>
            </a>

            <a href="#" id="link-aprobacion"
               onclick="showSection('aprobacion', this)"
               class="flex items-center space-x-3 px-4 py-2.5 rounded-lg text-sm font-medium text-zinc-300 hover:bg-zinc-800 hover:text-white transition-all duration-150 cursor-pointer">
                <i class="fa-solid fa-4 w-4 text-zinc-400"></i>
                <span>4. Aprobación y desembolso</span>
            </a>

            <p class="text-[9px] uppercase font-bold tracking-widest text-zinc-500 px-4 mt-4 mb-1">Recuperaciones</p>

            <a href="#" id="link-bandejamora"
               onclick="showSection('bandejamora', this)"
               class="flex items-center space-x-3 px-4 py-2.5 rounded-lg text-sm font-medium text-zinc-300 hover:bg-zinc-800 hover:text-white transition-all duration-150 cursor-pointer">
                <i class="fa-solid fa-triangle-exclamation w-4 text-zinc-400"></i>
                <span>Bandeja de mora</span>
            </a>

        </aside>

        {{-- MAIN CONTENT --}}
        <main class="flex-1 overflow-y-auto p-6 space-y-6">

            {{-- ==================== DASHBOARD ==================== --}}
            <div id="section-dashboard" class="space-y-6">

                <div class="flex justify-between items-start fade-in">
                    <div>
                        <h1 class="text-xl font-black text-zinc-800">Mi cartera</h1>
                        <p class="text-xs text-zinc-500 mt-0.5">
                            Indicadores de la cartera que gestionas &mdash;
                            <span class="font-bold text-zinc-700">{{ Session::get('usuario_nombre', 'Asesor') }}</span>
                        </p>
                    </div>
                    <div class="text-right">
                        <p class="text-[9px] uppercase font-bold text-zinc-500">Periodo (AAAAMM)</p>
                        <p class="text-lg font-black text-zinc-800 font-mono">{{ $ultimoPeriodo }}</p>
                    </div>
                </div>

                {{-- KPI Cards --}}
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-3 fade-in">
                    <div class="bg-white rounded-xl p-5 shadow-sm border border-zinc-100">
                        <p class="text-[9px] font-bold uppercase text-zinc-400 mb-1">Mi Cartera Total</p>
                        <p class="text-lg font-black text-zinc-800">S/ {{ number_format($totalCartera, 2) }}</p>
                    </div>
                    <div class="bg-white rounded-xl p-5 shadow-sm border border-zinc-100 border-l-2 border-l-emerald-400">
                        <p class="text-[9px] font-bold uppercase text-emerald-600 mb-1">Vigente</p>
                        <p class="text-lg font-black text-zinc-800">S/ {{ number_format($vigente, 2) }}</p>
                    </div>
                    <div class="bg-white rounded-xl p-5 shadow-sm border border-zinc-100 border-l-2 border-l-red-400">
                        <p class="text-[9px] font-bold uppercase text-red-600 mb-1">Vencida</p>
                        <p class="text-lg font-black text-red-600">S/ {{ number_format($vencida, 2) }}</p>
                    </div>
                    <div class="bg-white rounded-xl p-5 shadow-sm border border-zinc-100 border-l-2 border-l-orange-400">
                        <p class="text-[9px] font-bold uppercase text-orange-600 mb-1">Ratio de Mora</p>
                        <p class="text-lg font-black text-orange-500">{{ $ratioMora }}%</p>
                    </div>
                    <div class="bg-white rounded-xl p-5 shadow-sm border border-zinc-100">
                        <p class="text-[9px] font-bold uppercase text-zinc-400 mb-1">N° Créditos</p>
                        <p class="text-lg font-black text-zinc-800">{{ $numCreditos }}</p>
                    </div>
                    <div class="bg-white rounded-xl p-5 shadow-sm border border-zinc-100">
                        <p class="text-[9px] font-bold uppercase text-zinc-400 mb-1">Clientes</p>
                        <p class="text-lg font-black text-zinc-800">{{ $numClientes }}</p>
                    </div>
                </div>

                {{-- Charts --}}
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 fade-in">

                    <div class="bg-white rounded-xl shadow-sm border border-zinc-100 p-5">
                        <h3 class="text-xs font-bold uppercase text-zinc-500 tracking-wider mb-4">Composición de mi cartera</h3>
                        <div class="flex items-center justify-center gap-8">
                            <div class="w-40 h-40">
                                <canvas id="carterapie"></canvas>
                            </div>
                            <div class="space-y-2 text-xs">
                                <div class="flex items-center space-x-2">
                                    <span class="w-3 h-3 rounded-sm bg-zinc-700 inline-block"></span>
                                    <span class="text-zinc-600">Vencida &mdash; <span class="font-bold">S/ {{ number_format($vencida, 2) }}</span></span>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <span class="w-3 h-3 rounded-sm bg-teal-500 inline-block"></span>
                                    <span class="text-zinc-600">Vigente &mdash; <span class="font-bold">S/ {{ number_format($vigente, 2) }}</span></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-sm border border-zinc-100 p-5">
                        <h3 class="text-xs font-bold uppercase text-zinc-500 tracking-wider mb-4">Cumplimiento de meta</h3>
                        <div class="space-y-3">
                            <div>
                                <label class="text-[10px] text-zinc-500 font-medium">Meta de colocaciones (S/)</label>
                                <input id="meta-input" type="number" placeholder="Ej. 6000000"
                                       class="mt-1 w-full border border-zinc-200 rounded-lg px-3 py-2 text-sm font-mono outline-none focus:border-[#EC111A] transition">
                            </div>
                            <div id="meta-resultado" class="hidden space-y-2">
                                <div class="flex justify-between text-xs font-semibold text-zinc-700">
                                    <span>Avance actual</span>
                                    <span id="meta-pct" class="text-[#EC111A]">0%</span>
                                </div>
                                <div class="w-full bg-zinc-100 rounded-full h-3 overflow-hidden">
                                    <div id="meta-bar" class="h-3 bg-[#EC111A] rounded-full transition-all duration-700" style="width:0%"></div>
                                </div>
                                <p class="text-[10px] text-zinc-400">Cartera total: <span class="font-bold text-zinc-600">S/ {{ number_format($totalCartera, 2) }}</span></p>
                            </div>
                            <p id="meta-hint" class="text-[10px] text-zinc-400 italic">Asigna tu meta de colocaciones para ver el avance.</p>
                            <button onclick="calcularMeta()" class="bg-[#EC111A] hover:bg-red-700 text-white font-bold text-xs px-4 py-2 rounded-lg transition">
                                Calcular avance
                            </button>
                        </div>
                    </div>
                </div>

                {{-- Calificación --}}
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 fade-in">
                    <div class="bg-white rounded-xl shadow-sm border border-zinc-100 p-5">
                        <h3 class="text-xs font-bold uppercase text-zinc-500 tracking-wider mb-4">Cartera por calificación</h3>
                        <div class="space-y-3">
                            @php
                                $colorMap = ['00' => 'bg-emerald-500', '01' => 'bg-yellow-400', '02' => 'bg-orange-500', '03' => 'bg-red-500', '04' => 'bg-red-700'];
                                $maxMonto  = $calificaciones->max('monto') ?: 1;
                            @endphp
                            @foreach($calificaciones as $cal)
                            <div class="flex items-center space-x-3 text-xs">
                                <span class="w-16 text-zinc-400 font-mono font-bold shrink-0 truncate">{{ $cal->label }}</span>
                                <div class="flex-1 bg-zinc-100 rounded-full h-2.5 overflow-hidden">
                                    <div class="h-2.5 {{ $colorMap[$cal->cod] ?? 'bg-zinc-400' }} rounded-full"
                                         style="width: {{ $maxMonto > 0 ? round(($cal->monto / $maxMonto) * 100) : 0 }}%"></div>
                                </div>
                                <span class="text-zinc-700 font-bold w-28 text-right shrink-0">S/ {{ number_format($cal->monto, 2) }}</span>
                            </div>
                            @endforeach
                            @if($calificaciones->isEmpty())
                            <p class="text-xs text-zinc-400 italic">No hay datos de calificación para este periodo.</p>
                            @endif
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-sm border border-zinc-100 p-5">
                        <h3 class="text-xs font-bold uppercase text-zinc-500 tracking-wider mb-4">Bandeja rápida</h3>
                        <div class="space-y-2">
                            @php
                                $estadosSummary = $bandeja->groupBy('estado')->map->count();
                            @endphp
                            @foreach($estadosSummary as $estado => $count)
                            @php
                                $sc = match(true) {
                                    str_contains($estado, 'Evaluación') => 'bg-amber-50 text-amber-700',
                                    str_contains($estado, 'Comité')     => 'bg-purple-50 text-purple-700',
                                    str_contains($estado, 'Aprobado')   => 'bg-emerald-50 text-emerald-700',
                                    str_contains($estado, 'Desembolsado') => 'bg-blue-50 text-blue-700',
                                    str_contains($estado, 'Rechazado')  => 'bg-red-50 text-red-700',
                                    default => 'bg-zinc-100 text-zinc-600',
                                };
                            @endphp
                            <div class="flex items-center justify-between text-xs">
                                <span class="{{ $sc }} px-2 py-0.5 rounded-full font-bold">{{ $estado }}</span>
                                <span class="font-black text-zinc-700">{{ $count }}</span>
                            </div>
                            @endforeach
                            @if($estadosSummary->isEmpty())
                            <p class="text-xs text-zinc-400 italic">Sin solicitudes asignadas.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            {{-- ==================== BANDEJA DE SOLICITUDES ==================== --}}
            <div id="section-bandeja" class="hidden space-y-4">
                <div class="flex justify-between items-center fade-in">
                    <div>
                        <h1 class="text-xl font-black text-zinc-800">Bandeja de solicitudes</h1>
                        <p class="text-xs text-zinc-500 mt-0.5">Todas las solicitudes de crédito asignadas a tu cartera.</p>
                    </div>
                    <span class="text-[10px] font-bold uppercase bg-amber-100 text-amber-800 px-3 py-1 rounded-full">
                        {{ $bandeja->count() }} total(es)
                    </span>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-zinc-100 overflow-hidden fade-in">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm text-zinc-700">
                            <thead class="bg-zinc-50 text-[10px] uppercase font-bold text-zinc-400 border-b border-zinc-100">
                                <tr>
                                    <th class="px-5 py-3">Código</th>
                                    <th class="px-5 py-3">Cliente</th>
                                    <th class="px-5 py-3">Documento</th>
                                    <th class="px-5 py-3">Monto Solicitado</th>
                                    <th class="px-5 py-3">Plazo</th>
                                    <th class="px-5 py-3">Tipo</th>
                                    <th class="px-5 py-3">Estado</th>
                                    <th class="px-5 py-3 text-center">Acción</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-zinc-50">
                                @forelse($bandeja as $s)
                                @php
                                    $ec = match(true) {
                                        str_contains($s->estado, 'Evaluación')  => 'bg-amber-50 text-amber-700 border-amber-200',
                                        str_contains($s->estado, 'Comité')      => 'bg-purple-50 text-purple-700 border-purple-200',
                                        str_contains($s->estado, 'Aprobado')    => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                                        str_contains($s->estado, 'Desembolsado')=> 'bg-blue-50 text-blue-700 border-blue-200',
                                        str_contains($s->estado, 'Rechazado')   => 'bg-red-50 text-red-700 border-red-200',
                                        default                                  => 'bg-zinc-50 text-zinc-600 border-zinc-200',
                                    };
                                @endphp
                                <tr class="hover:bg-zinc-50 transition">
                                    <td class="px-5 py-3.5 font-mono text-xs font-bold text-zinc-600">{{ $s->codsolicitud }}</td>
                                    <td class="px-5 py-3.5 font-semibold text-zinc-800">{{ $s->cliente }}</td>
                                    <td class="px-5 py-3.5 text-xs text-zinc-500 font-mono">{{ $s->tipo_doc }} {{ $s->nro_doc }}</td>
                                    <td class="px-5 py-3.5 font-black text-zinc-800">S/ {{ number_format($s->monto, 2) }}</td>
                                    <td class="px-5 py-3.5 text-xs text-zinc-500">{{ $s->cuotas }} meses</td>
                                    <td class="px-5 py-3.5 text-xs text-zinc-500">{{ $s->tipo }}</td>
                                    <td class="px-5 py-3.5">
                                        <span class="text-[10px] font-bold border px-2 py-0.5 rounded-full {{ $ec }}">{{ $s->estado }}</span>
                                        @if($s->nivel_aprobacion)
                                        <p class="text-[9px] text-zinc-400 mt-1">{{ $s->nivel_aprobacion }}</p>
                                        @endif
                                    </td>
                                    <td class="px-5 py-3.5 text-center">
                                        @if($s->estado_id == 1)
                                        <button onclick="cargarPreSolicitud('{{ addslashes($s->cliente) }}', {{ $s->monto }}, {{ $s->cuotas }}, '{{ $s->fecha }}', '{{ $s->codsolicitud }}')"
                                                class="bg-[#EC111A] hover:bg-red-700 text-white font-bold text-xs px-3 py-1.5 rounded-lg shadow-sm transition">
                                            Revisar
                                        </button>
                                        @elseif($s->estado_id == 6)
                                        <button onclick="irAComite('{{ $s->codsolicitud }}')"
                                                class="bg-purple-600 hover:bg-purple-700 text-white font-bold text-xs px-3 py-1.5 rounded-lg shadow-sm transition">
                                            Comité
                                        </button>
                                        @elseif($s->estado_id == 2)
                                        <button onclick="irADesembolso('{{ $s->codsolicitud }}')"
                                                class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs px-3 py-1.5 rounded-lg shadow-sm transition">
                                            Desembolsar
                                        </button>
                                        @else
                                        <span class="text-[10px] text-zinc-400 italic">—</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="px-5 py-8 text-center text-xs text-zinc-400">
                                        <i class="fa-solid fa-inbox text-2xl text-zinc-200 mb-2 block"></i>
                                        No hay solicitudes asignadas a tu cartera.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- ==================== PRE-SOLICITUD ==================== --}}
            <div id="section-presolicitud" class="hidden space-y-4">
                <h1 class="text-xl font-black text-zinc-800 fade-in">1. Pre-solicitud</h1>
                <p class="text-xs text-zinc-500 fade-in">Búsqueda inicial del cliente y verificación de elegibilidad crediticia.</p>
                <div class="bg-white rounded-xl shadow-sm border border-zinc-100 p-6 max-w-xl fade-in">
                    <h3 class="text-sm font-bold text-zinc-700 mb-4">Buscar cliente por número de documento</h3>
                    <div class="flex space-x-3">
                        <select id="presol-doc-type" class="border border-zinc-200 rounded-lg px-3 py-2 text-sm outline-none focus:border-[#EC111A] transition bg-white">
                            <option value="DNI">DNI</option>
                            <option value="RUC">RUC</option>
                            <option value="CE">CE</option>
                            <option value="PAS">Pasaporte</option>
                        </select>
                        <input type="text" id="presol-doc-number" placeholder="Número de documento"
                               class="flex-1 border border-zinc-200 rounded-lg px-3 py-2 text-sm outline-none focus:border-[#EC111A] transition">
                        <button onclick="buscarPreSolicitud()" class="bg-[#EC111A] hover:bg-red-700 text-white font-bold text-sm px-4 py-2 rounded-lg transition">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </button>
                    </div>
                    <div id="presol-search-results" class="mt-6 p-4 bg-zinc-50 border border-zinc-200 rounded-lg text-center text-zinc-400 text-xs">
                        Los resultados de búsqueda aparecerán aquí.
                    </div>
                </div>
            </div>

            {{-- ==================== REGISTRO SOLICITUD ==================== --}}
            <div id="section-registrosolicitud" class="hidden space-y-4">
                <h1 class="text-xl font-black text-zinc-800 fade-in">2. Registro de solicitud</h1>
                <p class="text-xs text-zinc-500 fade-in">Ingreso formal de la solicitud de crédito con todos los datos del cliente y condiciones del crédito.</p>
                <div class="bg-white rounded-xl shadow-sm border border-zinc-100 p-6 fade-in">
                    <input type="hidden" id="reg-codsolicitud">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="text-[10px] uppercase font-bold text-zinc-400 block mb-1">Cliente</label>
                            <input type="text" id="reg-cliente-nombre" placeholder="Nombre completo del cliente" readonly
                                   class="w-full border border-zinc-200 rounded-lg px-3 py-2 text-sm outline-none bg-zinc-50 text-zinc-600 cursor-not-allowed">
                        </div>
                        <div>
                            <label class="text-[10px] uppercase font-bold text-zinc-400 block mb-1">Monto Solicitado (S/)</label>
                            <input type="number" id="reg-monto-solicitado" placeholder="0.00"
                                   class="w-full border border-zinc-200 rounded-lg px-3 py-2 text-sm outline-none focus:border-[#EC111A]">
                        </div>
                        <div>
                            <label class="text-[10px] uppercase font-bold text-zinc-400 block mb-1">Plazo (meses)</label>
                            <input type="number" id="reg-plazo-meses" placeholder="Ej. 12"
                                   class="w-full border border-zinc-200 rounded-lg px-3 py-2 text-sm outline-none focus:border-[#EC111A]">
                        </div>
                        <div>
                            <label class="text-[10px] uppercase font-bold text-zinc-400 block mb-1">Tipo de Crédito</label>
                            <select id="reg-tipo-credito" class="w-full border border-zinc-200 rounded-lg px-3 py-2 text-sm outline-none focus:border-[#EC111A] bg-white">
                                <option>Crédito Nuevo</option>
                                <option>Refinanciamiento</option>
                                <option>Ampliación</option>
                            </select>
                        </div>
                        <div>
                            <label class="text-[10px] uppercase font-bold text-zinc-400 block mb-1">Tasa Compensatoria Anual (%)</label>
                            <input type="number" id="reg-tasa-compensatoria" placeholder="Ej. 33.06" step="0.01"
                                   class="w-full border border-zinc-200 rounded-lg px-3 py-2 text-sm outline-none focus:border-[#EC111A]">
                        </div>
                        <div>
                            <label class="text-[10px] uppercase font-bold text-zinc-400 block mb-1">Fecha de Solicitud</label>
                            <input type="date" id="reg-fecha-solicitud"
                                   class="w-full border border-zinc-200 rounded-lg px-3 py-2 text-sm outline-none focus:border-[#EC111A]">
                        </div>
                    </div>

                    {{-- Simulación de cuota --}}
                    <div id="reg-simulacion" class="mt-4 hidden bg-zinc-50 border border-zinc-200 rounded-xl p-4">
                        <p class="text-[10px] font-bold uppercase text-zinc-400 mb-2">Simulación de Cuota</p>
                        <div class="grid grid-cols-3 gap-3 text-center">
                            <div>
                                <p class="text-[9px] text-zinc-400 uppercase font-bold">Cuota mensual</p>
                                <p id="sim-cuota" class="text-lg font-black text-zinc-800">—</p>
                            </div>
                            <div>
                                <p class="text-[9px] text-zinc-400 uppercase font-bold">Interés total</p>
                                <p id="sim-interes" class="text-lg font-black text-zinc-800">—</p>
                            </div>
                            <div>
                                <p class="text-[9px] text-zinc-400 uppercase font-bold">Costo total</p>
                                <p id="sim-total" class="text-lg font-black text-zinc-800">—</p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-5 flex justify-between items-center">
                        <button onclick="simularCuota()" class="bg-zinc-700 hover:bg-zinc-600 text-white font-bold text-xs px-4 py-2.5 rounded-lg transition">
                            <i class="fa-solid fa-calculator mr-1"></i> Simular cuota
                        </button>
                        <button id="btn-registrar-sol" onclick="registrarSolicitud()"
                                class="bg-[#EC111A] hover:bg-red-700 text-white font-bold text-sm px-5 py-2.5 rounded-lg transition">
                            Registrar Solicitud y Enviar a Comité
                        </button>
                    </div>
                </div>
            </div>

            {{-- ==================== PROPUESTA Y COMITÉ ==================== --}}
            <div id="section-propuesta" class="hidden space-y-4">
                <h1 class="text-xl font-black text-zinc-800 fade-in">3. Propuesta y Comité</h1>
                <p class="text-xs text-zinc-500 fade-in">Revisión de solicitudes en comité y aprobación del crédito.</p>

                <div class="bg-white rounded-xl shadow-sm border border-zinc-100 overflow-hidden fade-in">
                    @php $enComite = $bandeja->where('estado_id', 6); @endphp
                    @if($enComite->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm text-zinc-700">
                            <thead class="bg-zinc-50 text-[10px] uppercase font-bold text-zinc-400 border-b border-zinc-100">
                                <tr>
                                    <th class="px-5 py-3">Código</th>
                                    <th class="px-5 py-3">Cliente</th>
                                    <th class="px-5 py-3">Monto</th>
                                    <th class="px-5 py-3">Cuotas</th>
                                    <th class="px-5 py-3">Nivel requerido</th>
                                    <th class="px-5 py-3">Estado</th>
                                    <th class="px-5 py-3 text-center">Decisión</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-zinc-50">
                                @foreach($enComite as $s)
                                <tr class="hover:bg-zinc-50 transition">
                                    <td class="px-5 py-3.5 font-mono text-xs font-bold text-zinc-600">{{ $s->codsolicitud }}</td>
                                    <td class="px-5 py-3.5 font-semibold text-zinc-800">{{ $s->cliente }}</td>
                                    <td class="px-5 py-3.5 font-black">S/ {{ number_format($s->monto, 2) }}</td>
                                    <td class="px-5 py-3.5 text-xs text-zinc-500">{{ $s->cuotas }} meses</td>
                                    <td class="px-5 py-3.5 text-[10px] font-bold text-zinc-600">{{ $s->nivel_aprobacion ?? '—' }}</td>
                                    <td class="px-5 py-3.5">
                                        <span class="text-[10px] font-bold border px-2 py-0.5 rounded-full bg-purple-50 text-purple-700 border-purple-200">En Comité</span>
                                    </td>
                                    <td class="px-5 py-3.5 text-center">
                                        @if($puedeAprobar)
                                        <button onclick="aprobarSolicitud('{{ $s->codsolicitud }}')"
                                                class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs px-3 py-1.5 rounded-lg shadow-sm transition">
                                            <i class="fa-solid fa-check mr-1"></i> Aprobar
                                        </button>
                                        @else
                                        <span class="text-[10px] text-zinc-400 italic" title="Solo Administrador o Gerencia pueden aprobar solicitudes">
                                            <i class="fa-solid fa-lock mr-1"></i>Requiere Admin/Gerencia
                                        </span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <div class="p-10 flex flex-col items-center justify-center text-center">
                        <i class="fa-solid fa-users text-4xl text-zinc-200 mb-3"></i>
                        <p class="text-sm font-semibold text-zinc-500">No hay solicitudes en comité</p>
                        <p class="text-[11px] text-zinc-400 mt-1">Las solicitudes enviadas a comité desde el paso 2 aparecerán aquí.</p>
                    </div>
                    @endif
                </div>
            </div>

            {{-- ==================== APROBACIÓN Y DESEMBOLSO ==================== --}}
            <div id="section-aprobacion" class="hidden space-y-4">
                <h1 class="text-xl font-black text-zinc-800 fade-in">4. Aprobación y Desembolso</h1>
                <p class="text-xs text-zinc-500 fade-in">Registro del desembolso definitivo y generación de cuenta y cronograma.</p>

                <div class="bg-white rounded-xl shadow-sm border border-zinc-100 overflow-hidden fade-in">
                    @php $aprobadas = $bandeja->where('estado_id', 2); @endphp
                    @if($aprobadas->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm text-zinc-700">
                            <thead class="bg-zinc-50 text-[10px] uppercase font-bold text-zinc-400 border-b border-zinc-100">
                                <tr>
                                    <th class="px-5 py-3">Código</th>
                                    <th class="px-5 py-3">Cliente</th>
                                    <th class="px-5 py-3">Monto Aprobado</th>
                                    <th class="px-5 py-3">Cuotas</th>
                                    <th class="px-5 py-3">Estado</th>
                                    <th class="px-5 py-3 text-center">Acción</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-zinc-50">
                                @foreach($aprobadas as $s)
                                <tr class="hover:bg-zinc-50 transition">
                                    <td class="px-5 py-3.5 font-mono text-xs font-bold text-zinc-600">{{ $s->codsolicitud }}</td>
                                    <td class="px-5 py-3.5 font-semibold text-zinc-800">{{ $s->cliente }}</td>
                                    <td class="px-5 py-3.5 font-black text-emerald-700">S/ {{ number_format($s->monto, 2) }}</td>
                                    <td class="px-5 py-3.5 text-xs text-zinc-500">{{ $s->cuotas }} meses</td>
                                    <td class="px-5 py-3.5">
                                        <span class="text-[10px] font-bold border px-2 py-0.5 rounded-full bg-emerald-50 text-emerald-700 border-emerald-200">Aprobado</span>
                                    </td>
                                    <td class="px-5 py-3.5 text-center">
                                        <button onclick="desembolsarSolicitud('{{ $s->codsolicitud }}')"
                                                class="bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs px-3 py-1.5 rounded-lg shadow-sm transition">
                                            <i class="fa-solid fa-money-bill-wave mr-1"></i> Desembolsar
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <div class="p-10 flex flex-col items-center justify-center text-center">
                        <i class="fa-solid fa-hand-holding-dollar text-4xl text-zinc-200 mb-3"></i>
                        <p class="text-sm font-semibold text-zinc-500">No hay solicitudes aprobadas pendientes de desembolso</p>
                        <p class="text-[11px] text-zinc-400 mt-1">Las solicitudes aprobadas desde el comité aparecerán aquí para su desembolso.</p>
                    </div>
                    @endif
                </div>
            </div>

            {{-- ==================== BANDEJA DE MORA ==================== --}}
            <div id="section-bandejamora" class="hidden space-y-6">
                <div>
                    <h1 class="text-xl font-black text-zinc-800">Bandeja de Mora</h1>
                    <p class="text-xs text-zinc-500 mt-1">Gestión de cartera morosa — bandas regulatorias y registro de cobranza.</p>
                </div>

                {{-- R1: KPIs por banda --}}
                <div class="grid grid-cols-2 md:grid-cols-5 gap-3">
                    @php
                        $bandas = [
                            ['label'=>'Preventiva','sub'=>'1–30 días','cnt'=>$moraKpis->cnt_prev,'mon'=>$moraKpis->mon_prev,'color'=>'bg-blue-50 border-blue-200','tc'=>'text-blue-700','icon'=>'fa-shield-halved'],
                            ['label'=>'Temprana',  'sub'=>'31–60 días','cnt'=>$moraKpis->cnt_temp,'mon'=>$moraKpis->mon_temp,'color'=>'bg-yellow-50 border-yellow-200','tc'=>'text-yellow-700','icon'=>'fa-triangle-exclamation'],
                            ['label'=>'Tardía',    'sub'=>'61–120 días','cnt'=>$moraKpis->cnt_tard,'mon'=>$moraKpis->mon_tard,'color'=>'bg-orange-50 border-orange-200','tc'=>'text-orange-700','icon'=>'fa-clock-rotate-left'],
                            ['label'=>'Judicial',  'sub'=>'121–180 días','cnt'=>$moraKpis->cnt_judi,'mon'=>$moraKpis->mon_judi,'color'=>'bg-red-50 border-red-200','tc'=>'text-red-700','icon'=>'fa-gavel'],
                            ['label'=>'Castigo',   'sub'=>'>180 días','cnt'=>$moraKpis->cnt_cast,'mon'=>$moraKpis->mon_cast,'color'=>'bg-zinc-100 border-zinc-300','tc'=>'text-zinc-700','icon'=>'fa-skull-crossbones'],
                        ];
                    @endphp
                    @foreach($bandas as $b)
                    <div class="rounded-xl border p-4 {{ $b['color'] }}">
                        <div class="flex items-center gap-2 mb-2">
                            <i class="fa-solid {{ $b['icon'] }} text-sm {{ $b['tc'] }}"></i>
                            <span class="text-xs font-bold {{ $b['tc'] }}">{{ $b['label'] }}</span>
                        </div>
                        <p class="text-[10px] text-zinc-400 mb-1">{{ $b['sub'] }}</p>
                        <p class="text-xl font-black {{ $b['tc'] }}">{{ number_format($b['cnt']) }}</p>
                        <p class="text-[10px] text-zinc-500">créditos</p>
                        <p class="text-xs font-semibold text-zinc-600 mt-1">S/ {{ number_format($b['mon'], 0) }}</p>
                    </div>
                    @endforeach
                </div>

                {{-- Ratio global --}}
                @php
                    $ratioGlobal = $moraKpis->total_cartera_global > 0
                        ? round(($moraKpis->total_vencida_global / $moraKpis->total_cartera_global) * 100, 2)
                        : 0;
                @endphp
                <div class="bg-white rounded-xl border border-zinc-100 px-5 py-3 flex items-center gap-4">
                    <i class="fa-solid fa-chart-pie text-[#EC111A] text-lg"></i>
                    <div>
                        <p class="text-xs text-zinc-400">Índice de mora global (cartera total)</p>
                        <p class="text-base font-black {{ $ratioGlobal > 15 ? 'text-red-600' : ($ratioGlobal > 8 ? 'text-yellow-600' : 'text-green-600') }}">
                            {{ $ratioGlobal }}%
                            <span class="text-xs font-normal text-zinc-400 ml-1">
                                {{ $ratioGlobal > 15 ? '🔴 Crítico' : ($ratioGlobal > 8 ? '🟡 Alerta' : '🟢 Normal') }}
                            </span>
                        </p>
                    </div>
                    <div class="ml-auto text-right">
                        <p class="text-xs text-zinc-400">Cartera vencida total</p>
                        <p class="text-sm font-bold text-zinc-700">S/ {{ number_format($moraKpis->total_vencida_global, 0) }}</p>
                    </div>
                </div>

                {{-- R1: Tabla de créditos morosos --}}
                <div class="bg-white rounded-xl border border-zinc-100 overflow-hidden">
                    <div class="px-5 py-3 border-b border-zinc-100 flex items-center justify-between">
                        <h2 class="text-sm font-bold text-zinc-800">
                            <i class="fa-solid fa-list-ul mr-1 text-[#EC111A]"></i>
                            Créditos morosos en tu cartera ({{ $creditosMorosos->count() }})
                        </h2>
                        <input id="mora-filtro" type="text" placeholder="Buscar cliente o cuenta..."
                               class="text-xs border border-zinc-200 rounded-lg px-3 py-1.5 w-48 focus:outline-none focus:ring-1 focus:ring-[#EC111A]">
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-xs" id="tabla-morosos">
                            <thead class="bg-zinc-50 text-zinc-500 uppercase text-[10px] tracking-wide">
                                <tr>
                                    <th class="px-4 py-2 text-left">Cuenta</th>
                                    <th class="px-4 py-2 text-left">Cliente</th>
                                    <th class="px-4 py-2 text-left">Doc.</th>
                                    <th class="px-4 py-2 text-center">Días atraso</th>
                                    <th class="px-4 py-2 text-center">Banda</th>
                                    <th class="px-4 py-2 text-right">Saldo capital</th>
                                    <th class="px-4 py-2 text-right">Saldo vencido</th>
                                    <th class="px-4 py-2 text-center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-zinc-50">
                                @forelse($creditosMorosos as $cm)
                                @php
                                    $badgeColor = match($cm->banda) {
                                        'CASTIGO'    => 'bg-zinc-200 text-zinc-700',
                                        'JUDICIAL'   => 'bg-red-100 text-red-700',
                                        'TARDÍA'     => 'bg-orange-100 text-orange-700',
                                        'TEMPRANA'   => 'bg-yellow-100 text-yellow-700',
                                        default      => 'bg-blue-100 text-blue-700',
                                    };
                                @endphp
                                <tr class="hover:bg-zinc-50 fila-moroso">
                                    <td class="px-4 py-2 font-mono text-zinc-600">{{ $cm->codcuentacredito }}</td>
                                    <td class="px-4 py-2 font-medium text-zinc-800">{{ $cm->cliente }}</td>
                                    <td class="px-4 py-2 text-zinc-500">{{ $cm->nro_doc }}</td>
                                    <td class="px-4 py-2 text-center font-bold text-zinc-700">{{ $cm->dias }}</td>
                                    <td class="px-4 py-2 text-center">
                                        <span class="px-2 py-0.5 rounded-full text-[10px] font-bold {{ $badgeColor }}">
                                            {{ $cm->banda }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-2 text-right text-zinc-700">S/ {{ number_format($cm->saldo_capital, 2) }}</td>
                                    <td class="px-4 py-2 text-right font-semibold text-red-600">S/ {{ number_format($cm->saldo_vencido, 2) }}</td>
                                    <td class="px-4 py-2 text-center">
                                        <div class="flex items-center justify-center gap-1">
                                            {{-- R2: Registrar gestión --}}
                                            <button onclick="abrirModalGestion({{ $cm->pkcuentacredito }}, '{{ addslashes($cm->cliente) }}', '{{ $cm->banda }}')"
                                                    class="text-[10px] bg-zinc-100 hover:bg-zinc-200 text-zinc-700 px-2 py-1 rounded-lg transition">
                                                <i class="fa-solid fa-pen-to-square mr-1"></i>Gestionar
                                            </button>
                                            {{-- R3: Judicial (solo si dias >= 121, no judicial aún, y rol autorizado) --}}
                                            @if($cm->dias >= 121 && $cm->flagjudicial !== 'S' && $cm->flagcastigado !== 'S')
                                                @if($puedeDecidirMora)
                                                <button onclick="accionMora('judicial', {{ $cm->pkcuentacredito }}, '{{ addslashes($cm->cliente) }}')"
                                                        class="text-[10px] bg-red-50 hover:bg-red-100 text-red-700 px-2 py-1 rounded-lg transition">
                                                    <i class="fa-solid fa-gavel mr-1"></i>Judicial
                                                </button>
                                                @else
                                                <span class="text-[10px] text-zinc-400 italic px-2 py-1" title="Solo Riesgos o Gerencia pueden derivar a judicial">
                                                    <i class="fa-solid fa-lock mr-1"></i>Requiere Riesgos
                                                </span>
                                                @endif
                                            @endif
                                            {{-- R3: Castigo (solo si dias > 180, no castigado aún, y rol autorizado) --}}
                                            @if($cm->dias > 180 && $cm->flagcastigado !== 'S')
                                                @if($puedeDecidirMora)
                                                <button onclick="accionMora('castigar', {{ $cm->pkcuentacredito }}, '{{ addslashes($cm->cliente) }}')"
                                                        class="text-[10px] bg-zinc-700 hover:bg-zinc-900 text-white px-2 py-1 rounded-lg transition">
                                                    <i class="fa-solid fa-ban mr-1"></i>Castigar
                                                </button>
                                                @else
                                                <span class="text-[10px] text-zinc-400 italic px-2 py-1" title="Solo Riesgos o Gerencia pueden castigar créditos">
                                                    <i class="fa-solid fa-lock mr-1"></i>Requiere Riesgos
                                                </span>
                                                @endif
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="px-4 py-8 text-center text-zinc-400 text-xs">
                                        <i class="fa-solid fa-circle-check text-2xl text-green-400 block mb-2"></i>
                                        No tienes créditos con días de atraso en tu cartera.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- R2: Historial de gestiones --}}
                <div class="bg-white rounded-xl border border-zinc-100 overflow-hidden">
                    <div class="px-5 py-3 border-b border-zinc-100">
                        <h2 class="text-sm font-bold text-zinc-800">
                            <i class="fa-solid fa-clock-rotate-left mr-1 text-[#EC111A]"></i>
                            Historial de gestiones recientes
                        </h2>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-xs">
                            <thead class="bg-zinc-50 text-zinc-500 uppercase text-[10px] tracking-wide">
                                <tr>
                                    <th class="px-4 py-2 text-left">Fecha</th>
                                    <th class="px-4 py-2 text-left">Cuenta</th>
                                    <th class="px-4 py-2 text-left">Cliente</th>
                                    <th class="px-4 py-2 text-left">Tipo</th>
                                    <th class="px-4 py-2 text-center">Banda</th>
                                    <th class="px-4 py-2 text-center">Días</th>
                                    <th class="px-4 py-2 text-left">Resultado</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-zinc-50">
                                @forelse($historialGestiones as $hg)
                                <tr class="hover:bg-zinc-50">
                                    <td class="px-4 py-2 text-zinc-500">{{ \Carbon\Carbon::parse($hg->fechagestion)->format('d/m/Y') }}</td>
                                    <td class="px-4 py-2 font-mono text-zinc-600 text-[10px]">{{ $hg->codcuentacredito }}</td>
                                    <td class="px-4 py-2 text-zinc-700">{{ $hg->cliente }}</td>
                                    <td class="px-4 py-2 text-zinc-600">{{ $hg->tipo_gestion }}</td>
                                    <td class="px-4 py-2 text-center">
                                        <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-zinc-100 text-zinc-600">
                                            {{ $hg->banda ?? '—' }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-2 text-center font-bold text-zinc-700">{{ $hg->dias ?? '—' }}</td>
                                    <td class="px-4 py-2 text-zinc-500 max-w-xs truncate">{{ $hg->resultado }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="px-4 py-6 text-center text-zinc-400 text-xs">
                                        Aún no hay gestiones registradas. Usa el botón "Gestionar" en un crédito moroso.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- MODAL R2: Registrar Gestión de Cobranza --}}
            <div id="modal-gestion" class="fixed inset-0 bg-black/40 z-50 hidden items-center justify-center">
                <div class="bg-white rounded-2xl shadow-xl w-full max-w-md mx-4 p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-base font-bold text-zinc-800">
                            <i class="fa-solid fa-pen-to-square mr-2 text-[#EC111A]"></i>Registrar gestión de cobranza
                        </h3>
                        <button onclick="cerrarModalGestion()" class="text-zinc-400 hover:text-zinc-700">
                            <i class="fa-solid fa-xmark text-lg"></i>
                        </button>
                    </div>
                    <div class="bg-zinc-50 rounded-xl p-3 mb-4 text-xs text-zinc-600">
                        <span class="font-semibold" id="modal-cliente-nombre">—</span>
                        <span class="ml-2 px-2 py-0.5 rounded-full bg-zinc-200 text-zinc-700 text-[10px]" id="modal-banda-label">—</span>
                    </div>
                    <input type="hidden" id="modal-pkcuenta">
                    <div class="space-y-3">
                        <div>
                            <label class="text-xs text-zinc-500 font-medium block mb-1">Tipo de gestión</label>
                            <select id="modal-tipo-gestion" class="w-full border border-zinc-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-[#EC111A]">
                                @foreach($tiposGestion as $tg)
                                <option value="{{ $tg->pktipogestion }}">{{ $tg->destipogestion }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="text-xs text-zinc-500 font-medium block mb-1">Resultado / observación</label>
                            <textarea id="modal-resultado" rows="3"
                                      placeholder="Ej: Se contactó al cliente, prometió pagar el 15/07..."
                                      class="w-full border border-zinc-200 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-[#EC111A] resize-none"></textarea>
                        </div>
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="text-xs text-zinc-500 font-medium block mb-1">Compromiso de pago (opcional)</label>
                                <input type="date" id="modal-compromiso"
                                       class="w-full border border-zinc-200 rounded-lg px-3 py-2 text-sm focus:outline-none">
                            </div>
                            <div>
                                <label class="text-xs text-zinc-500 font-medium block mb-1">Monto comprometido (opcional)</label>
                                <input type="number" id="modal-monto" placeholder="0.00" step="0.01"
                                       class="w-full border border-zinc-200 rounded-lg px-3 py-2 text-sm focus:outline-none">
                            </div>
                        </div>
                    </div>
                    <div class="flex gap-2 mt-5">
                        <button onclick="cerrarModalGestion()"
                                class="flex-1 border border-zinc-200 text-zinc-600 py-2 rounded-xl text-sm hover:bg-zinc-50 transition">
                            Cancelar
                        </button>
                        <button onclick="guardarGestion()"
                                class="flex-1 bg-[#EC111A] text-white py-2 rounded-xl text-sm font-semibold hover:bg-red-700 transition">
                            <i class="fa-solid fa-floppy-disk mr-1"></i>Guardar gestión
                        </button>
                    </div>
                </div>
            </div>

            {{-- ==================== MODAL DE CONFIRMACIÓN (reemplaza confirm() nativo) ==================== --}}
            <div id="modal-confirm" class="fixed inset-0 bg-black/40 z-50 hidden items-center justify-center">
                <div class="bg-white rounded-2xl shadow-xl w-full max-w-md mx-4 p-6">
                    <div class="flex items-center justify-between mb-3">
                        <h3 class="text-base font-bold text-zinc-800" id="confirm-titulo">
                            <i class="fa-solid fa-triangle-exclamation mr-2 text-[#EC111A]"></i>Confirmar acción
                        </h3>
                        <button onclick="cerrarConfirm(false)" class="text-zinc-400 hover:text-zinc-700">
                            <i class="fa-solid fa-xmark text-lg"></i>
                        </button>
                    </div>
                    <p id="confirm-mensaje" class="text-sm text-zinc-600 whitespace-pre-line mb-5">—</p>
                    <div class="flex gap-2">
                        <button onclick="cerrarConfirm(false)"
                                class="flex-1 border border-zinc-200 text-zinc-600 py-2 rounded-xl text-sm hover:bg-zinc-50 transition">
                            Cancelar
                        </button>
                        <button onclick="cerrarConfirm(true)"
                                class="flex-1 bg-[#EC111A] text-white py-2 rounded-xl text-sm font-semibold hover:bg-red-700 transition">
                            <i class="fa-solid fa-check mr-1"></i>Confirmar
                        </button>
                    </div>
                </div>
            </div>

        </main>
    </div>

    {{-- Toast notification --}}
    <div id="toast" class="toast hidden"></div>

    <script>
        const CSRF = document.querySelector('meta[name="csrf-token"]').content;

        // ===================================================
        // Navegación
        // ===================================================
        function showSection(name, el) {
            document.querySelectorAll('[id^="section-"]').forEach(s => s.classList.add('hidden'));
            document.getElementById('section-' + name).classList.remove('hidden');
            document.querySelectorAll('aside a').forEach(link => {
                link.classList.remove('bg-[#EC111A]/10', 'text-white', 'font-semibold');
                link.classList.add('text-zinc-300', 'font-medium');
            });
            el.classList.remove('text-zinc-300', 'font-medium');
            el.classList.add('bg-[#EC111A]/10', 'text-white', 'font-semibold');
        }

        // ===================================================
        // Modal de confirmación (reemplaza confirm() nativo)
        // ===================================================
        let _confirmResolve = null;
        function pedirConfirmacion(mensaje, titulo = 'Confirmar acción') {
            document.getElementById('confirm-titulo').innerHTML =
                '<i class="fa-solid fa-triangle-exclamation mr-2 text-[#EC111A]"></i>' + titulo;
            document.getElementById('confirm-mensaje').textContent = mensaje;
            const modal = document.getElementById('modal-confirm');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            return new Promise((resolve) => { _confirmResolve = resolve; });
        }
        function cerrarConfirm(resultado) {
            const modal = document.getElementById('modal-confirm');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            if (_confirmResolve) { _confirmResolve(resultado); _confirmResolve = null; }
        }

        // ===================================================
        // Toast
        // ===================================================
        function showToast(msg, type = 'success') {
            const t = document.getElementById('toast');
            t.textContent = msg;
            t.className = 'toast toast-' + type;
            setTimeout(() => t.classList.add('hidden'), 4000);
        }

        // ===================================================
        // Paso 1 — Búsqueda de cliente
        // ===================================================
        function buscarPreSolicitud() {
            const tipoDoc  = document.getElementById('presol-doc-type').value;
            const documento = document.getElementById('presol-doc-number').value.trim();
            const results   = document.getElementById('presol-search-results');

            if (!documento) { alert('Por favor ingrese el número de documento.'); return; }

            results.innerHTML = '<div class="text-zinc-400 py-4"><i class="fa-solid fa-spinner animate-spin mr-2"></i>Buscando...</div>';
            results.className = 'mt-6 p-4 bg-zinc-50 border border-zinc-200 rounded-lg text-center text-xs';

            fetch(`/asesor/buscar-cliente?tipo_doc=${tipoDoc}&documento=${documento}`)
                .then(r => r.json())
                .then(data => {
                    if (!data.success) {
                        results.innerHTML = `<div class="text-red-500 font-semibold py-2"><i class="fa-solid fa-circle-exclamation mr-2"></i>${data.message}</div>`;
                        return;
                    }
                    const c = data.cliente;
                    const ev = data.evaluacion;
                    let html = `
                        <div class="text-left space-y-4">
                            <div class="border-b border-zinc-100 pb-3">
                                <h4 class="text-xs font-bold uppercase text-zinc-400">Cliente Encontrado</h4>
                                <p class="text-sm font-bold text-zinc-800 mt-1">${c.nombre}</p>
                                <p class="text-xs text-zinc-500 font-mono mt-0.5">${c.tipo_documento}: ${c.documento}</p>
                            </div>
                    `;

                    if (ev) {
                        const colorMap = { verde: 'bg-emerald-50 text-emerald-700 border-emerald-200', amarillo: 'bg-amber-50 text-amber-700 border-amber-200', rojo: 'bg-red-50 text-red-700 border-red-200', gris: 'bg-zinc-50 text-zinc-500 border-zinc-200' };
                        const scoreClass = colorMap[ev.score_color] || colorMap.gris;
                        const rdsClass   = colorMap[ev.rds_color]   || colorMap.gris;
                        const emoji = { verde: '🟢', amarillo: '🟡', rojo: '🔴', gris: '⚪' };

                        html += `
                            <div class="grid grid-cols-2 gap-2">
                                <div class="border rounded-lg p-2.5 ${scoreClass}">
                                    <p class="text-[9px] uppercase font-bold opacity-70">Scoring crediticio</p>
                                    <p class="text-sm font-black">${emoji[ev.score_color]} ${ev.score}/100 — ${ev.score_nivel}</p>
                                    ${ev.creditos_castigados > 0 ? '<p class="text-[9px] mt-0.5">⚠️ Tiene créditos castigados</p>' : ''}
                                    ${ev.max_dias_atraso > 0 ? `<p class="text-[9px] mt-0.5">Máx. atraso histórico: ${ev.max_dias_atraso} días</p>` : ''}
                                </div>
                                <div class="border rounded-lg p-2.5 ${rdsClass}">
                                    <p class="text-[9px] uppercase font-bold opacity-70">RDS (Relación Deuda-Servicio)</p>
                                    ${ev.rds !== null
                                        ? `<p class="text-sm font-black">${emoji[ev.rds_color]} ${ev.rds}% — ${ev.rds_nivel}</p>`
                                        : `<p class="text-[10px] italic">Sin datos suficientes (ingreso o monto no registrado)</p>`}
                                </div>
                            </div>
                        `;
                    }

                    if (data.solicitudes.length === 0) {
                        html += `<div class="bg-amber-50 border border-amber-100 rounded-lg p-3 text-amber-800 text-xs flex items-center space-x-2">
                            <i class="fa-solid fa-circle-info text-amber-500 mr-2"></i>
                            <span>El cliente no tiene pre-solicitudes en evaluación.</span>
                        </div>`;
                    } else {
                        html += `<div><h4 class="text-xs font-bold uppercase text-zinc-400 mb-2">Pre-solicitudes en Evaluación</h4><div class="space-y-2.5">`;
                        data.solicitudes.forEach(s => {
                            const fmt = parseFloat(s.monto).toLocaleString('es-PE', {minimumFractionDigits:2, maximumFractionDigits:2});
                            const name = c.nombre.replace(/'/g, "\\'");
                            html += `
                                <div class="border border-zinc-150 rounded-xl p-3 bg-white hover:bg-zinc-50 transition flex justify-between items-center shadow-sm">
                                    <div class="space-y-1">
                                        <div class="flex items-center space-x-2">
                                            <span class="font-mono text-xs font-bold text-[#EC111A]">${s.codsolicitud}</span>
                                            <span class="text-[10px] font-bold bg-[#EC111A]/10 text-[#EC111A] px-2 py-0.5 rounded-full">${s.estado}</span>
                                        </div>
                                        <p class="text-xs text-zinc-700 font-semibold">${s.producto}</p>
                                        <p class="text-[10px] text-zinc-400">Fecha: ${s.fecha} | Plazo: ${s.cuotas} Meses</p>
                                    </div>
                                    <div class="text-right flex flex-col items-end space-y-2">
                                        <span class="text-sm font-black text-zinc-800">S/ ${fmt}</span>
                                        <button onclick="cargarPreSolicitud('${name}', ${s.monto}, ${s.cuotas}, '${s.fecha}', '${s.codsolicitud}')"
                                                class="bg-[#EC111A] hover:bg-red-700 text-white font-bold text-[10px] px-2.5 py-1.5 rounded-lg shadow-sm transition uppercase tracking-wider">
                                            Cargar en Registro
                                        </button>
                                    </div>
                                </div>
                            `;
                        });
                        html += `</div></div>`;
                    }
                    html += `</div>`;
                    results.className = 'mt-6 p-5 bg-zinc-50 border border-zinc-200 rounded-xl';
                    results.innerHTML = html;
                })
                .catch(() => {
                    results.innerHTML = '<div class="text-red-500 font-semibold py-2"><i class="fa-solid fa-circle-exclamation mr-2"></i>Error al consultar el servidor.</div>';
                });
        }

        // ===================================================
        // Cargar datos en el formulario de registro
        // ===================================================
        function cargarPreSolicitud(nombre, monto, cuotas, fecha, codsolicitud) {
            document.getElementById('reg-codsolicitud').value      = codsolicitud;
            document.getElementById('reg-cliente-nombre').value   = nombre;
            document.getElementById('reg-monto-solicitado').value = monto;
            document.getElementById('reg-plazo-meses').value      = cuotas;
            document.getElementById('reg-tasa-compensatoria').value= '33.06';
            document.getElementById('reg-fecha-solicitud').value  = fecha;
            showSection('registrosolicitud', document.getElementById('link-registrosolicitud'));
        }

        // ===================================================
        // Simulador de cuota
        // ===================================================
        function simularCuota() {
            const monto  = parseFloat(document.getElementById('reg-monto-solicitado').value);
            const cuotas = parseInt(document.getElementById('reg-plazo-meses').value);
            const tea    = parseFloat(document.getElementById('reg-tasa-compensatoria').value) / 100;
            if (!monto || !cuotas || !tea) { showToast('Ingresa monto, cuotas y tasa primero.', 'error'); return; }

            const tem    = Math.pow(1 + tea, 1/12) - 1;
            const cuota  = monto * (tem * Math.pow(1 + tem, cuotas)) / (Math.pow(1 + tem, cuotas) - 1);
            const total  = cuota * cuotas;
            const interes= total - monto;

            document.getElementById('sim-cuota').textContent   = 'S/ ' + cuota.toLocaleString('es-PE', {minimumFractionDigits:2, maximumFractionDigits:2});
            document.getElementById('sim-interes').textContent = 'S/ ' + interes.toLocaleString('es-PE', {minimumFractionDigits:2, maximumFractionDigits:2});
            document.getElementById('sim-total').textContent   = 'S/ ' + total.toLocaleString('es-PE', {minimumFractionDigits:2, maximumFractionDigits:2});
            document.getElementById('reg-simulacion').classList.remove('hidden');
        }

        // ===================================================
        // Paso 2 — Registrar solicitud
        // ===================================================
        function registrarSolicitud() {
            const codsolicitud = document.getElementById('reg-codsolicitud').value;
            if (!codsolicitud) { showToast('Carga primero una pre-solicitud desde el paso 1.', 'error'); return; }

            const btn = document.getElementById('btn-registrar-sol');
            btn.disabled = true;
            btn.textContent = 'Enviando...';

            fetch('/asesor/registrar-solicitud', {
                method: 'POST',
                headers: {'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': CSRF},
                body: JSON.stringify({
                    codsolicitud,
                    monto : document.getElementById('reg-monto-solicitado').value,
                    cuotas: document.getElementById('reg-plazo-meses').value,
                    tasa  : document.getElementById('reg-tasa-compensatoria').value,
                })
            })
            .then(async r => {
                if (!r.ok) {
                    const txt = await r.text();
                    console.error('Respuesta del servidor (no-OK):', r.status, txt);
                    throw new Error(`HTTP ${r.status}: revisa la consola (F12) para el detalle.`);
                }
                return r.json();
            })
            .then(data => {
                if (data.success) {
                    showToast('✅ ' + data.message);
                    setTimeout(() => location.reload(), 2000);
                } else {
                    showToast('❌ ' + data.message, 'error');
                    btn.disabled = false;
                    btn.textContent = 'Registrar Solicitud y Enviar a Comité';
                }
            })
            .catch(err => { showToast('Error: ' + err.message, 'error'); btn.disabled = false; });
        }

        // ===================================================
        // Helpers para navegar directo a sección con código
        // ===================================================
        function irAComite(codsolicitud) {
            showSection('propuesta', document.getElementById('link-propuesta'));
        }

        function irADesembolso(codsolicitud) {
            showSection('aprobacion', document.getElementById('link-aprobacion'));
        }

        // ===================================================
        // Paso 3 — Aprobar solicitud
        // ===================================================
        function aprobarSolicitud(codsolicitud) {
            pedirConfirmacion(`¿Confirmas la APROBACIÓN de la solicitud ${codsolicitud}?`, 'Aprobar solicitud').then((ok) => {
                if (!ok) return;

            fetch('/asesor/aprobar-solicitud', {
                method: 'POST',
                headers: {'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': CSRF},
                body: JSON.stringify({ codsolicitud })
            })
            .then(async r => {
                if (!r.ok) {
                    const txt = await r.text();
                    console.error('Respuesta del servidor (no-OK):', r.status, txt);
                    throw new Error(`HTTP ${r.status}: revisa la consola (F12) para el detalle.`);
                }
                return r.json();
            })
            .then(data => {
                if (data.success) {
                    showToast('✅ ' + data.message);
                    setTimeout(() => location.reload(), 2000);
                } else {
                    showToast('❌ ' + data.message, 'error');
                }
            })
            .catch(err => showToast('Error: ' + err.message, 'error'));
            });
        }

        // ===================================================
        // Paso 4 — Desembolsar
        // ===================================================
        function desembolsarSolicitud(codsolicitud) {
            pedirConfirmacion(`¿Confirmas el DESEMBOLSO definitivo de la solicitud ${codsolicitud}? Se creará la cuenta de ahorros, la cuenta de crédito y el cronograma de pagos.`, 'Desembolsar crédito').then((ok) => {
                if (!ok) return;

fetch('/asesor/desembolsar-solicitud', {
                method: 'POST',
                headers: {'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': CSRF},
                body: JSON.stringify({ codsolicitud })
            })
            .then(async r => {
                if (!r.ok) {
                    const txt = await r.text();
                    console.error('Respuesta del servidor (no-OK):', r.status, txt);
                    throw new Error(`HTTP ${r.status}: revisa la consola (F12) para el detalle.`);
                }
                return r.json();
            })
            .then(data => {
                if (data.success) {
                    showToast(`✅ ${data.message} | Cuenta: ${data.cod_cuenta} | ${data.cuotas_generadas} cuotas generadas`);
                    setTimeout(() => location.reload(), 3000);
                } else {
                    showToast('❌ ' + data.message, 'error');
                }
            })
            .catch(err => showToast('Error: ' + err.message, 'error'));
            });
        }

        // ===================================================
        // Gráfico de dona
        // ===================================================
        const ctx = document.getElementById('carterapie').getContext('2d');
        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Vencida', 'Vigente'],
                datasets: [{
                    data: [{{ $vencida }}, {{ $vigente }}],
                    backgroundColor: ['#27272a', '#14b8a6'],
                    borderWidth: 0,
                }]
            },
            options: {
                cutout: '65%',
                plugins: { legend: { display: false } }
            }
        });

        // ===================================================
        // Calculadora de meta
        // ===================================================
        const _carteraTotal = {{ $totalCartera }};
        function calcularMeta() {
            const meta = parseFloat(document.getElementById('meta-input').value);
            if (!meta || meta <= 0) return;
            const pct = Math.min((_carteraTotal / meta) * 100, 100).toFixed(1);
            document.getElementById('meta-pct').textContent    = pct + '%';
            document.getElementById('meta-bar').style.width   = pct + '%';
            document.getElementById('meta-resultado').classList.remove('hidden');
            document.getElementById('meta-hint').classList.add('hidden');
        }

        // ============================================================
        // MÓDULO DE MORA — JavaScript (R1 filtro, R2 modal, R3 acciones)
        // ============================================================

        // R1: filtro en tiempo real de la tabla de morosos
        document.getElementById('mora-filtro').addEventListener('input', function () {
            const q = this.value.toLowerCase();
            document.querySelectorAll('#tabla-morosos .fila-moroso').forEach(function (fila) {
                fila.style.display = fila.textContent.toLowerCase().includes(q) ? '' : 'none';
            });
        });

        // R2: Modal de gestión
        function abrirModalGestion(pkCuenta, nombreCliente, banda) {
            document.getElementById('modal-pkcuenta').value    = pkCuenta;
            document.getElementById('modal-cliente-nombre').textContent = nombreCliente;
            document.getElementById('modal-banda-label').textContent    = banda;
            document.getElementById('modal-resultado').value  = '';
            document.getElementById('modal-compromiso').value = '';
            document.getElementById('modal-monto').value      = '';
            document.getElementById('modal-gestion').classList.remove('hidden');
            document.getElementById('modal-gestion').classList.add('flex');
        }

        function cerrarModalGestion() {
            document.getElementById('modal-gestion').classList.add('hidden');
            document.getElementById('modal-gestion').classList.remove('flex');
        }

        function guardarGestion() {
            const pkCuenta    = document.getElementById('modal-pkcuenta').value;
            const pkTipo      = document.getElementById('modal-tipo-gestion').value;
            const resultado   = document.getElementById('modal-resultado').value.trim();
            const compromiso  = document.getElementById('modal-compromiso').value;
            const monto       = document.getElementById('modal-monto').value;

            if (!resultado) { showToast('Ingresa el resultado u observación de la gestión.', 'error'); return; }

            fetch('/asesor/registrar-gestion', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': CSRF },
                body: JSON.stringify({
                    pkcuentacredito:  pkCuenta,
                    pktipogestion:    pkTipo,
                    resultado:        resultado,
                    compromisopago:   compromiso || null,
                    montocomprometido: monto || null,
                })
            })
            .then(async r => {
                if (!r.ok) {
                    const txt = await r.text();
                    console.error('Respuesta del servidor (no-OK):', r.status, txt);
                    throw new Error(`HTTP ${r.status}: revisa la consola (F12) para el detalle.`);
                }
                return r.json();
            })
            .then(data => {
                if (data.success) {
                    showToast(data.message, 'success');
                    cerrarModalGestion();
                    setTimeout(() => location.reload(), 1200);
                } else {
                    showToast(data.message, 'error');
                }
            })
            .catch(err => showToast('Error: ' + err.message, 'error'));
        }

        // R3: Derivar a judicial o castigar
        function accionMora(tipo, pkCuenta, nombreCliente) {
            const mensajes = {
                judicial: `¿Confirma derivar a COBRANZA JUDICIAL el crédito de "${nombreCliente}"?\n\nEsta acción queda registrada en el historial.`,
                castigar: `¿Confirma CASTIGAR el crédito de "${nombreCliente}"?\n\nEsta acción es irreversible y quedará registrada.`,
            };
            const rutas = {
                judicial: '/asesor/derivar-judicial',
                castigar: '/asesor/castigar-credito',
            };

            pedirConfirmacion(mensajes[tipo], 'Acción de mora').then((ok) => {
                if (!ok) return;

            fetch(rutas[tipo], {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': CSRF },
                body: JSON.stringify({ pkcuentacredito: pkCuenta })
            })
            .then(async r => {
                if (!r.ok) {
                    const txt = await r.text();
                    console.error('Respuesta del servidor (no-OK):', r.status, txt);
                    throw new Error(`HTTP ${r.status}: revisa la consola (F12) para el detalle.`);
                }
                return r.json();
            })
            .then(data => {
                if (data.success) {
                    showToast(data.message, 'success');
                    setTimeout(() => location.reload(), 1500);
                } else {
                    showToast(data.message, 'error');
                }
            })
            .catch(err => showToast('Error: ' + err.message, 'error'));
            });
        }

        // Cerrar modal al hacer clic fuera
        document.getElementById('modal-gestion').addEventListener('click', function (e) {
            if (e.target === this) cerrarModalGestion();
        });
    </script>
</body>
</html>