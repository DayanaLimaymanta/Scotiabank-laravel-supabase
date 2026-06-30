<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Banco - Scotiabank</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;900&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(16px); }
            to   { opacity: 1; transform: translateY(0);    }
        }
        .fade-in { animation: fadeInUp 0.4s ease both; }
        .card-hover { transition: box-shadow .2s, transform .2s; }
        .card-hover:hover { box-shadow: 0 8px 30px rgba(0,0,0,.1); transform: translateY(-2px); }
    </style>
</head>
<body class="bg-[#f4f6f9] text-gray-800">

    <!-- NAVBAR -->
    <nav class="bg-white shadow-sm border-b-4 border-[#EC111A] sticky top-0 z-50">
        <div class="max-w-6xl mx-auto px-6 h-16 flex justify-between items-center">
            <div class="text-red-600 font-extrabold text-3xl tracking-tight flex items-center">
                <span class="bg-red-600 text-white rounded-full w-8 h-8 flex items-center justify-center text-xl mr-2 font-serif">S</span>
                Scotiabank<span class="text-red-600 text-xs align-top mt-1">®</span>
            </div>
            <div class="flex items-center space-x-4">
                <div class="flex items-center space-x-2 bg-gray-50 px-3 py-1.5 rounded-lg border border-gray-100">
                    <div class="w-7 h-7 bg-[#EC111A]/10 text-[#EC111A] rounded-full flex items-center justify-center font-bold text-xs uppercase">
                        {{ strtoupper(substr(Session::get('usuario_nombre', 'U'), 0, 2)) }}
                    </div>
                    <span class="text-xs font-semibold text-gray-700">Hola, {{ Session::get('usuario_nombre') }}</span>
                </div>
                <a href="/logout" class="text-xs text-gray-500 hover:text-[#EC111A] font-medium flex items-center space-x-1 transition">
                    <i class="fa-solid fa-power-off"></i>
                    <span class="hidden sm:inline">Cerrar Sesión</span>
                </a>
            </div>
        </div>
    </nav>

    <!-- SUB-NAV -->
    <div class="bg-white border-b border-gray-200 shadow-sm">
        <div class="max-w-6xl mx-auto px-6 flex space-x-8 text-xs font-semibold h-12 items-center text-gray-600">
            <a href="#inicio"    class="text-[#EC111A] border-b-2 border-[#EC111A] h-full flex items-center px-1">Inicio</a>
            <a href="#cuentas"   class="hover:text-[#EC111A] transition h-full flex items-center px-1">Mis Cuentas</a>
            <a href="#prestamos" class="hover:text-[#EC111A] transition h-full flex items-center px-1">Préstamos</a>
            <a href="#solicitudes" class="hover:text-[#EC111A] transition h-full flex items-center px-1">Mis Solicitudes</a>
        </div>
    </div>

    <!-- ALERTS -->
    <div class="max-w-6xl mx-auto px-6 pt-4">
        @if(Session::has('success'))
            <div class="bg-emerald-50 border-l-4 border-emerald-500 text-emerald-800 p-4 rounded-lg text-xs font-semibold flex items-start space-x-2 fade-in">
                <i class="fa-solid fa-circle-check text-emerald-500 mt-0.5"></i>
                <span>{{ Session::get('success') }}</span>
            </div>
        @endif
        @if(Session::has('error'))
            <div class="bg-red-50 border-l-4 border-red-500 text-red-800 p-4 rounded-lg text-xs font-semibold flex items-start space-x-2 fade-in">
                <i class="fa-solid fa-circle-exclamation text-red-500 mt-0.5"></i>
                <span>{{ Session::get('error') }}</span>
            </div>
        @endif
    </div>

    <main id="inicio" class="max-w-6xl mx-auto px-6 py-6 grid grid-cols-1 lg:grid-cols-3 gap-8">

        <!-- COLUMNA PRINCIPAL -->
        <div class="lg:col-span-2 space-y-6">

            <!-- Saludo -->
            <div class="fade-in">
                <h2 class="text-xl font-bold text-gray-800">Hola, {{ Session::get('usuario_nombre') }} 👋</h2>
                <p class="text-xs text-gray-500 mt-1">Esta es la posición global de tus productos financieros vigentes.</p>
            </div>

            <!-- KPIs -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 fade-in" style="animation-delay:.05s">
                <div class="bg-white border border-gray-200/80 rounded-xl p-5 shadow-sm card-hover">
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">
                            <i class="fa-solid fa-piggy-bank mr-1 text-[#EC111A]"></i> Total en Ahorros
                        </p>
                        <h4 class="text-2xl font-black text-gray-800">S/ {{ number_format($ahorrosTotal, 2) }}</h4>
                        <p class="text-[10px] text-gray-400 mt-1">
                            {{ $cuentas->count() }} {{ $cuentas->count() == 1 ? 'cuenta activa' : 'cuentas activas' }}
                        </p>
                    </div>
                </div>
                <div class="bg-white border border-gray-200/80 rounded-xl p-5 shadow-sm card-hover">
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1">
                            <i class="fa-solid fa-hand-holding-dollar mr-1 text-gray-700"></i> Deuda en Préstamos
                        </p>
                        <h4 class="text-2xl font-black text-gray-800">S/ {{ number_format($deudaTotal, 2) }}</h4>
                        <p class="text-[10px] text-gray-400 mt-1">
                            {{ $prestamos->count() }} {{ $prestamos->count() == 1 ? 'crédito por pagar' : 'créditos por pagar' }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Cuentas de Ahorro -->
            <div id="cuentas" class="bg-white border border-gray-200/80 rounded-xl shadow-sm overflow-hidden fade-in" style="animation-delay:.1s">
                <div class="bg-gray-50 border-b border-gray-100 px-5 py-3 flex justify-between items-center">
                    <h3 class="text-xs font-bold uppercase tracking-wider text-gray-500">Cuentas de Ahorro</h3>
                    <span class="text-xs text-gray-400">{{ $cuentas->count() }} cuenta(s)</span>
                </div>
                <div class="divide-y divide-gray-100">
                    @forelse($cuentas as $cuenta)
                    <div class="p-5 flex justify-between items-center hover:bg-gray-50/50 transition cursor-pointer">
                        <div class="flex items-center space-x-4">
                            <div class="w-9 h-9 bg-red-50 text-[#EC111A] rounded-full flex items-center justify-center text-sm">
                                <i class="fa-solid fa-wallet"></i>
                            </div>
                            <div>
                                <h4 class="text-sm font-bold text-gray-800">{{ $cuenta->producto }}</h4>
                                <p class="text-xs text-gray-400 font-mono">CTA: ****-{{ substr($cuenta->codcuentaahorro, -4) }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <span class="text-xs font-bold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-full inline-block mb-1">
                                {{ $cuenta->estado }}
                            </span>
                            <p class="text-lg font-black text-gray-800">S/ {{ number_format($cuenta->saldo, 2) }}</p>
                        </div>
                    </div>
                    @empty
                    <div class="p-6 text-center text-xs text-gray-400">
                        <i class="fa-solid fa-piggy-bank text-2xl text-gray-200 mb-2 block"></i>
                        No tienes cuentas de ahorro registradas aún.
                    </div>
                    @endforelse
                </div>
            </div>

            <!-- Créditos -->
            <div id="prestamos" class="bg-white border border-gray-200/80 rounded-xl shadow-sm overflow-hidden fade-in" style="animation-delay:.15s">
                <div class="bg-gray-50 border-b border-gray-100 px-5 py-3 flex justify-between items-center">
                    <h3 class="text-xs font-bold uppercase tracking-wider text-gray-500">Préstamos y Financiamientos</h3>
                    <span class="text-xs text-gray-400">{{ $prestamos->count() }} crédito(s)</span>
                </div>
                <div class="divide-y divide-gray-100">
                    @forelse($prestamos as $prestamo)
                    <div class="p-5 flex justify-between items-center hover:bg-gray-50/50 transition cursor-pointer">
                        <div class="flex items-center space-x-4">
                            <div class="w-9 h-9 bg-gray-100 text-gray-700 rounded-full flex items-center justify-center text-sm">
                                <i class="fa-solid fa-file-invoice-dollar"></i>
                            </div>
                            <div>
                                <h4 class="text-sm font-bold text-gray-800">{{ $prestamo->producto }}</h4>
                                <p class="text-xs text-gray-400 font-mono">CRÉD: ****-{{ substr($prestamo->codcuentacredito, -4) }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            @php
                                $calTag = $prestamo->calificacion;
                                $calClass = str_contains(strtolower($calTag), 'normal')
                                    ? 'text-amber-600 bg-amber-50'
                                    : (str_contains(strtolower($calTag), 'pérdida') ? 'text-red-700 bg-red-50' : 'text-orange-600 bg-orange-50');
                            @endphp
                            <span class="text-xs font-bold {{ $calClass }} px-2 py-0.5 rounded-full inline-block mb-1">
                                {{ $calTag }}
                            </span>
                            <p class="text-lg font-black text-gray-800">S/ {{ number_format($prestamo->saldo, 2) }}</p>
                        </div>
                    </div>
                    @empty
                    <div class="p-6 text-center text-xs text-gray-400">
                        <i class="fa-solid fa-hand-holding-dollar text-2xl text-gray-200 mb-2 block"></i>
                        No tienes créditos activos registrados.
                    </div>
                    @endforelse
                </div>
            </div>

            <!-- Mis Solicitudes activas -->
            @if($solCliente->count() > 0)
            <div id="solicitudes" class="bg-white border border-gray-200/80 rounded-xl shadow-sm overflow-hidden fade-in" style="animation-delay:.2s">
                <div class="bg-gray-50 border-b border-gray-100 px-5 py-3 flex justify-between items-center">
                    <h3 class="text-xs font-bold uppercase tracking-wider text-gray-500">Mis Pre-Solicitudes en Proceso</h3>
                    <span class="text-[10px] font-bold bg-amber-100 text-amber-800 px-2 py-0.5 rounded-full">{{ $solCliente->count() }} activa(s)</span>
                </div>
                <div class="divide-y divide-gray-100">
                    @foreach($solCliente as $sol)
                    @php
                        $estadoId = $sol->estado ?? '';
                        $estClass = match(true) {
                            str_contains($estadoId, 'Evaluación') => 'bg-amber-50 text-amber-700 border-amber-200',
                            str_contains($estadoId, 'Comité')     => 'bg-purple-50 text-purple-700 border-purple-200',
                            str_contains($estadoId, 'Aprobado')   => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                            str_contains($estadoId, 'Rechazado')  => 'bg-red-50 text-red-700 border-red-200',
                            default                                => 'bg-gray-50 text-gray-700 border-gray-200',
                        };
                    @endphp
                    <div class="p-5 flex justify-between items-center hover:bg-gray-50/50 transition">
                        <div class="flex items-center space-x-4">
                            <div class="w-9 h-9 bg-blue-50 text-blue-600 rounded-full flex items-center justify-center text-sm">
                                <i class="fa-solid fa-clock-rotate-left"></i>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-gray-700">{{ $sol->producto }}</p>
                                <p class="text-[10px] text-gray-400 font-mono">{{ $sol->codsolicitud }} &mdash; {{ $sol->fecha }}</p>
                                <p class="text-[10px] text-gray-500 mt-0.5">{{ $sol->cuotas }} cuotas</p>
                            </div>
                        </div>
                        <div class="text-right space-y-1">
                            <span class="text-[10px] font-bold border px-2 py-0.5 rounded-full block {{ $estClass }}">{{ $sol->estado }}</span>
                            <p class="text-base font-black text-gray-800">S/ {{ number_format($sol->monto, 2) }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

        </div>

        <!-- COLUMNA LATERAL -->
        <div class="space-y-6">

            <!-- Panel de operaciones -->
            <div class="bg-white border border-gray-200/80 rounded-xl shadow-sm overflow-hidden fade-in" style="animation-delay:.1s">
                <div class="bg-gradient-to-r from-slate-900 to-zinc-800 px-5 py-4 text-white">
                    <h3 class="text-xs font-bold uppercase tracking-widest text-zinc-400">Panel de Control</h3>
                    <h4 class="text-sm font-bold mt-0.5">Operaciones Frecuentes</h4>
                </div>
                <div class="p-3 space-y-1">
                    <a href="#" class="flex items-center justify-between p-3 rounded-lg hover:bg-gray-50 text-gray-700 transition group">
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 bg-[#EC111A]/5 text-[#EC111A] rounded-lg flex items-center justify-center text-sm group-hover:bg-[#EC111A] group-hover:text-white transition">
                                <i class="fa-solid fa-money-bill-transfer"></i>
                            </div>
                            <span class="text-xs font-semibold">Transferencias Scotiabank</span>
                        </div>
                        <i class="fa-solid fa-chevron-right text-[10px] text-gray-400 group-hover:translate-x-1 transition"></i>
                    </a>

                    <a href="#" class="flex items-center justify-between p-3 rounded-lg hover:bg-gray-50 text-gray-700 transition group">
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 bg-blue-50 text-blue-600 rounded-lg flex items-center justify-center text-sm group-hover:bg-blue-600 group-hover:text-white transition">
                                <i class="fa-solid fa-building-columns"></i>
                            </div>
                            <span class="text-xs font-semibold">Transferencias Interbancarias</span>
                        </div>
                        <i class="fa-solid fa-chevron-right text-[10px] text-gray-400 group-hover:translate-x-1 transition"></i>
                    </a>

                    <a href="/solicitar-prestamo" class="flex items-center justify-between p-3 rounded-lg bg-blue-50 hover:bg-blue-600 text-blue-700 hover:text-white transition group">
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 bg-blue-600 text-white rounded-lg flex items-center justify-center text-sm">
                                <i class="fa-solid fa-hand-holding-dollar"></i>
                            </div>
                            <span class="text-xs font-bold">Solicitar Préstamo Efectivo</span>
                        </div>
                        <i class="fa-solid fa-chevron-right text-[10px] text-blue-400 group-hover:text-white group-hover:translate-x-1 transition"></i>
                    </a>

                    <a href="#" class="flex items-center justify-between p-3 rounded-lg hover:bg-gray-50 text-gray-700 transition group">
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 bg-purple-50 text-purple-600 rounded-lg flex items-center justify-center text-sm group-hover:bg-purple-600 group-hover:text-white transition">
                                <i class="fa-solid fa-credit-card"></i>
                            </div>
                            <span class="text-xs font-semibold">Pagar Tarjeta de Crédito</span>
                        </div>
                        <i class="fa-solid fa-chevron-right text-[10px] text-gray-400 group-hover:translate-x-1 transition"></i>
                    </a>

                    <a href="#" class="flex items-center justify-between p-3 rounded-lg hover:bg-gray-50 text-gray-700 transition group">
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 bg-emerald-50 text-emerald-600 rounded-lg flex items-center justify-center text-sm group-hover:bg-emerald-600 group-hover:text-white transition">
                                <i class="fa-solid fa-bolt"></i>
                            </div>
                            <span class="text-xs font-semibold">Pago de Recibos y Servicios</span>
                        </div>
                        <i class="fa-solid fa-chevron-right text-[10px] text-gray-400 group-hover:translate-x-1 transition"></i>
                    </a>
                </div>
            </div>

            <!-- Banner -->
            <div class="bg-gradient-to-br from-[#EC111A] to-red-700 p-5 rounded-xl text-white shadow-md relative overflow-hidden fade-in" style="animation-delay:.15s">
                <div class="absolute -right-6 -bottom-6 w-24 h-24 bg-white/10 rounded-full pointer-events-none"></div>
                <h4 class="text-xs font-bold uppercase tracking-wider text-red-200 mb-1">Campaña de Invierno</h4>
                <p class="text-sm font-bold leading-tight">Disfruta de hasta 50% de descuento en restaurantes seleccionados pagando con tus tarjetas.</p>
                <a href="#" class="mt-3 inline-block bg-white text-[#EC111A] font-bold text-[10px] px-3 py-1.5 rounded uppercase tracking-wider hover:bg-gray-50 transition">Ver locales</a>
            </div>

        </div>
    </main>
</body>
</html>