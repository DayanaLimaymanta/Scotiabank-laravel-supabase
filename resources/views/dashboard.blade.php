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
    </style>
</head>
<body class="bg-[#f4f6f9] text-gray-800">

    <nav class="bg-white shadow-sm border-b-4 border-[#EC111A] sticky top-0 z-50">
        <div class="max-w-6xl mx-auto px-6 h-16 flex justify-between items-center">
                    <div class="text-red-600 font-extrabold text-3xl tracking-tight flex items-center">
                        <span class="bg-red-600 text-white rounded-full w-8 h-8 flex items-center justify-center text-xl mr-2 font-serif">S</span>
                        Scotiabank<span class="text-red-600 text-xs align-top mt-1">®</span>
                    </div>
            
            <div class="flex items-center space-x-4">
                <div class="flex items-center space-x-2 bg-gray-50 px-3 py-1.5 rounded-lg border border-gray-100">
                    <div class="w-7 h-7 bg-[#EC111A]/10 text-[#EC111A] rounded-full flex items-center justify-center font-bold text-xs uppercase">
                        {{ substr(Session::get('usuario_nombre', 'U'), 0, 2) }}
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

    <div class="bg-white border-b border-gray-200 shadow-sm">
        <div class="max-w-6xl mx-auto px-6 flex space-x-8 text-xs font-semibold h-12 items-center text-gray-600">
            <a href="#" class="text-[#EC111A] border-b-2 border-[#EC111A] h-full flex items-center px-1">Inicio</a>
            <a href="#" class="hover:text-[#EC111A] transition h-full flex items-center px-1">Mis Cuentas</a>
            <a href="#" class="hover:text-[#EC1明A] transition h-full flex items-center px-1">Tarjetas de Crédito</a>
            <a href="#" class="hover:text-[#EC111A] transition h-full flex items-center px-1">Préstamos</a>
            <a href="#" class="hover:text-[#EC111A] transition h-full flex items-center px-1">Transferencias y Pagos</a>
        </div>
    </div>

    <main class="max-w-6xl mx-auto px-6 py-8 grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <div class="lg:col-span-2 space-y-6">
            
            <div>
                <h2 class="text-xl font-bold text-gray-800">Hola, {{ Session::get('usuario_nombre') }}</h2>
                <p class="text-xs text-gray-500 mt-1">Esta es la posición global de tus productos financieros vigentes.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="bg-white border border-gray-200/80 rounded-xl p-5 shadow-sm flex items-center justify-between">
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1"><i class="fa-solid fa-piggy-bank mr-1 text-[#EC111A]"></i> Total en Ahorros</p>
                        <h4 class="text-2xl font-black text-gray-800">S/ 4,500.00</h4>
                        <p class="text-[10px] text-gray-400 mt-1">1 cuenta activa</p>
                    </div>
                </div>
                <div class="bg-white border border-gray-200/80 rounded-xl p-5 shadow-sm flex items-center justify-between">
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-1"><i class="fa-solid fa-hand-holding-dollar mr-1 text-gray-700"></i> Deuda en Préstamos</p>
                        <h4 class="text-2xl font-black text-gray-800">S/ 12,000.00</h4>
                        <p class="text-[10px] text-gray-400 mt-1">1 crédito por pagar</p>
                    </div>
                </div>
            </div>

            <div class="bg-white border border-gray-200/80 rounded-xl shadow-sm overflow-hidden">
                <div class="bg-gray-50 border-b border-gray-100 px-5 py-3 flex justify-between items-center">
                    <h3 class="text-xs font-bold uppercase tracking-wider text-gray-500">Cuentas de Ahorro y Corrientes</h3>
                    <a href="#" class="text-xs text-[#0082c3] hover:underline font-medium">Ver todas</a>
                </div>
                
                <div class="divide-y divide-gray-100">
                    <div class="p-5 flex justify-between items-center hover:bg-gray-50/50 transition cursor-pointer">
                        <div class="flex items-center space-x-4">
                            <div class="w-9 h-9 bg-red-50 text-[#EC111A] rounded-full flex items-center justify-center text-sm">
                                <i class="fa-solid fa-wallet"></i>
                            </div>
                            <div>
                                <h4 class="text-sm font-bold text-gray-800">Cuenta Free - Soles</h4>
                                <p class="text-xs text-gray-400 font-mono">CTA: ****-****-3902</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <span class="text-xs font-bold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-full inline-block mb-1">Activa</span>
                            <p class="text-lg font-black text-gray-800">S/ 4,500.00</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white border border-gray-200/80 rounded-xl shadow-sm overflow-hidden">
                <div class="bg-gray-50 border-b border-gray-100 px-5 py-3 flex justify-between items-center">
                    <h3 class="text-xs font-bold uppercase tracking-wider text-gray-500">Préstamos y Financiamientos</h3>
                    <a href="#" class="text-xs text-[#0082c3] hover:underline font-medium">Ver todos</a>
                </div>
                
                <div class="divide-y divide-gray-100">
                    <div class="p-5 flex justify-between items-center hover:bg-gray-50/50 transition cursor-pointer">
                        <div class="flex items-center space-x-4">
                            <div class="w-9 h-9 bg-gray-100 text-gray-700 rounded-full flex items-center justify-center text-sm">
                                <i class="fa-solid fa-file-invoice-dollar"></i>
                            </div>
                            <div>
                                <h4 class="text-sm font-bold text-gray-800">Préstamo Personal Efectivo</h4>
                                <p class="text-xs text-gray-400 font-mono">CRÉD: ****-****-8812</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <span class="text-xs font-bold text-amber-600 bg-amber-50 px-2 py-0.5 rounded-full inline-block mb-1">Normal</span>
                            <p class="text-lg font-black text-gray-800">S/ 12,000.00</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="space-y-6">
            <div class="bg-white border border-gray-200/80 rounded-xl shadow-sm overflow-hidden">
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
                            <span class="text-xs font-semibold">Transferencias cuentas Scotiabank</span>
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

            <div class="bg-gradient-to-br from-[#EC111A] to-red-700 p-5 rounded-xl text-white shadow-md relative overflow-hidden">
                <div class="absolute -right-6 -bottom-6 w-24 h-24 bg-white/10 rounded-full pointer-events-none"></div>
                <h4 class="text-xs font-bold uppercase tracking-wider text-red-200 mb-1">Campaña de Invierno</h4>
                <p class="text-sm font-bold leading-tight">Disfruta de hasta 50% de descuento en restaurantes seleccionados pagando con tus tarjetas.</p>
                <a href="#" class="mt-3 inline-block bg-white text-[#EC111A] font-bold text-[10px] px-3 py-1.5 rounded uppercase tracking-wider hover:bg-gray-50 transition">Ver locales</a>
            </div>
        </div>

    </main>

</body>
</html>