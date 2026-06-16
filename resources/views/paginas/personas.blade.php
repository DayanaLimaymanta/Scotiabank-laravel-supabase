@extends('layouts.app')

@section('titulo', 'Personas')

@section('active-personas', 'text-gray-900 border-red-600')

@section('logo-banco')
<div class="text-red-600 font-extrabold text-3xl tracking-tight flex items-center select-none">
    <span class="bg-red-600 text-white rounded-full w-8 h-8 flex items-center justify-center text-xl mr-2 font-serif">S</span>
    Scotiabank<span class="text-red-600 text-xs align-top mt-1">®</span>
</div>
@endsection

@section('contenido')
<section class="relative bg-gradient-to-r from-red-700 to-red-600 text-white min-h-[420px] flex items-center overflow-hidden">
    <div class="absolute -right-16 -bottom-16 w-96 h-96 bg-red-500 rounded-full opacity-20 pointer-events-none"></div>
    <div class="absolute right-1/4 top-10 w-64 h-64 bg-red-400 rounded-full opacity-10 pointer-events-none"></div>

    <div class="max-w-6xl mx-auto px-6 w-full grid grid-cols-1 md:grid-cols-2 gap-8 items-center py-12">
        <div class="space-y-6 z-10">
            <h1 class="text-4xl md:text-5xl font-black tracking-tight leading-tight">
                ¡Gana S/50 SIN sorteos!
            </h1>
            <p class="text-lg text-red-100">
                Abre tu primera Cuenta Digital y empieza a disfrutar los beneficios exclusivos desde el primer día.
            </p>
            
            <ul class="space-y-3 text-sm text-red-50">
                <li class="flex items-center space-x-3">
                    <i class="fa-solid fa-arrow-right-arrow-left text-red-300"></i>
                    <span>Aprovecha un tipo de cambio preferencial.</span>
                </li>
                <li class="flex items-center space-x-3">
                    <i class="fa-solid fa-mobile-screen-button text-red-300"></i>
                    <span>Realiza transferencias digitales gratuitas.</span>
                </li>
            </ul>

            <div class="flex space-x-4 pt-2">
                <a href="{{ route('register') }}" class="bg-white text-red-600 hover:bg-gray-100 font-bold px-6 py-3 rounded-full text-sm shadow-lg transition">
                    Ábrela aquí
                </a>
                <a href="#" class="border border-white hover:bg-white/10 text-white font-semibold px-6 py-3 rounded-full text-sm transition">
                    Conoce más
                </a>
            </div>
        </div>

        <div class="flex justify-center md:justify-end z-10">
            <div class="bg-white/10 backdrop-blur-md border border-white/20 p-6 rounded-2xl max-w-sm text-center shadow-2xl relative">
                <div class="bg-red-600 text-white p-5 rounded-xl shadow-xl space-y-4">
                    <div class="bg-white p-3 rounded-lg inline-block mx-auto">
                        <i class="fa-solid fa-qrcode text-6xl text-gray-900"></i>
                    </div>
                    <h3 class="font-bold text-base">Hazte cliente Scotiabank aquí</h3>
                    <p class="text-xs text-red-100">Escanea el código QR desde tu celular y abre tu Cuenta Digital al instante.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="max-w-6xl mx-auto px-6 py-16">
    <div class="text-center max-w-xl mx-auto mb-12">
        <h2 class="text-2xl font-bold text-gray-900 mb-3">Nuestros productos más solicitados</h2>
        <p class="text-sm text-gray-500">Encuentra la solución financiera ideal que se adapte mejor a tus necesidades diarias.</p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm hover:shadow-md transition flex flex-col justify-between">
            <div>
                <div class="w-12 h-12 bg-red-50 text-red-600 rounded-lg flex items-center justify-center text-xl mb-4">
                    <i class="fa-solid fa-credit-card"></i>
                </div>
                <h3 class="font-bold text-gray-900 text-lg mb-2">Tarjetas de Crédito</h3>
                <p class="text-gray-500 text-sm leading-relaxed mb-4">
                    Acumula puntos en cada compra, obtén devoluciones de efectivo y accede a miles de promociones.
                </p>
            </div>
            <a href="#" class="text-red-600 font-semibold text-sm inline-flex items-center hover:underline">
                Ver opciones <i class="fa-solid fa-arrow-right text-xs ml-2"></i>
            </a>
        </div>

        <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm hover:shadow-md transition flex flex-col justify-between">
            <div>
                <div class="w-12 h-12 bg-red-50 text-red-600 rounded-lg flex items-center justify-center text-xl mb-4">
                    <i class="fa-solid fa-hand-holding-dollar"></i>
                </div>
                <h3 class="font-bold text-gray-900 text-lg mb-2">Préstamos Personales</h3>
                <p class="text-gray-500 text-sm leading-relaxed mb-4">
                    Financiación inmediata con tasas preferenciales para hacer realidad tus proyectos personales.
                </p>
            </div>
            <a href="#" class="text-red-600 font-semibold text-sm inline-flex items-center hover:underline">
                Cotizar préstamo <i class="fa-solid fa-arrow-right text-xs ml-2"></i>
            </a>
        </div>

        <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm hover:shadow-md transition flex flex-col justify-between">
            <div>
                <div class="w-12 h-12 bg-red-50 text-red-600 rounded-lg flex items-center justify-center text-xl mb-4">
                    <i class="fa-solid fa-shield-halved"></i>
                </div>
                <h3 class="font-bold text-gray-900 text-lg mb-2">Seguros Vehiculares</h3>
                <p class="text-gray-500 text-sm leading-relaxed mb-4">
                    Protege tu auto con pólizas flexibles, grúa gratis y soporte técnico mecánico las 24 horas.
                </p>
            </div>
            <a href="#" class="text-red-600 font-semibold text-sm inline-flex items-center hover:underline">
                Conocer coberturas <i class="fa-solid fa-arrow-right text-xs ml-2"></i>
            </a>
        </div>
    </div>
</section>
@endsection