@extends('layouts.app')

@section('titulo', 'Canales de Atención')

@section('active-personas', 'text-gray-900 border-red-600')
@section('active-canales', 'text-red-600 border-red-600 font-bold')

@section('logo-banco')
    <div class="text-red-600 font-extrabold text-3xl tracking-tight flex items-center select-none">
        <span class="bg-red-600 text-white rounded-full w-8 h-8 flex items-center justify-center text-xl mr-2 font-serif">S</span>
        Scotiabank<span class="text-gray-500 font-normal text-xs ml-1 tracking-tight uppercase">Canales</span>
    </div>
@endsection

@section('contenido')
<section class="relative bg-gradient-to-r from-red-800 to-zinc-900 text-white min-h-[420px] flex items-center overflow-hidden border-t-4 border-red-600">
    <div class="absolute -right-10 -bottom-10 w-80 h-80 bg-red-600 rounded-full opacity-10 pointer-events-none"></div>

    <div class="max-w-6xl mx-auto px-6 w-full grid grid-cols-1 md:grid-cols-2 gap-8 items-center py-12">
        <div class="space-y-6 z-10">
            <span class="text-red-300 uppercase tracking-widest text-xs font-bold bg-red-600/20 px-3 py-1 rounded-full">Operaciones 24/7</span>
            <h1 class="text-4xl md:text-5xl font-black tracking-tight leading-tight">
                El banco en tus manos, <br>donde estés.
            </h1>
            <p class="text-base text-gray-200">
                Realiza tus consultas, transferencias y pagos sin salir de casa mediante nuestra App Scotiabank y Banca por Web de forma 100% segura.
            </p>
            <ul class="space-y-3 text-sm text-gray-300">
                <li class="flex items-center space-x-3">
                    <i class="fa-solid fa-shield-halved text-red-400"></i>
                    <span>Seguridad garantizada con tu Token Digital integrado.</span>
                </li>
                <li class="flex items-center space-x-3">
                    <i class="fa-solid fa-circle-dollar-to-slot text-red-400"></i>
                    <span>Cero comisiones en transferencias interbancarias vía App.</span>
                </li>
            </ul>

            <div class="pt-2">
                <a href="#" class="bg-red-600 hover:bg-red-700 text-white font-bold px-8 py-3.5 rounded-lg text-sm shadow-xl transition inline-block">
                    Descargar App Scotiabank
                </a>
            </div>
        </div>

        <!-- Elemento Visual Interactivo simulando la App -->
        <div class="flex justify-center md:justify-end z-10">
            <div class="bg-zinc-900/90 border border-zinc-800 p-6 rounded-3xl w-full max-w-sm shadow-2xl text-white space-y-4">
                <div class="flex justify-between items-center border-b border-zinc-800 pb-3">
                    <div class="flex items-center space-x-2">
                        <div class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></div>
                        <p class="text-xs text-zinc-400">Banca por Internet Activa</p>
                    </div>
                    <i class="fa-solid fa-fingerprint text-xl text-red-500"></i>
                </div>
                <div class="space-y-1">
                    <p class="text-[10px] uppercase text-zinc-500 tracking-wider">Saldo Disponible Total</p>
                    <h4 class="text-2xl font-bold tracking-tight">S/ 4,850.20</h4>
                </div>
                <div class="grid grid-cols-2 gap-2 pt-2">
                    <div class="bg-zinc-800/50 p-3 rounded-xl border border-zinc-700/50 text-center hover:bg-zinc-800 transition cursor-pointer">
                        <i class="fa-solid fa-money-bill-transfer text-red-400 mb-1"></i>
                        <p class="text-[11px] font-medium block">Transferir</p>
                    </div>
                    <div class="bg-zinc-800/50 p-3 rounded-xl border border-zinc-700/50 text-center hover:bg-zinc-800 transition cursor-pointer">
                        <i class="fa-solid fa-receipt text-red-400 mb-1"></i>
                        <p class="text-[11px] font-medium block">Pagar Servicios</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- SECCIÓN DE CANALES FÍSICOS -->
<section class="max-w-6xl mx-auto px-6 py-16">
    <div class="text-center max-w-xl mx-auto mb-12">
        <h2 class="text-2xl font-bold text-gray-900 mb-2">Nuestra red a tu servicio</h2>
        <p class="text-sm text-gray-500">Si prefieres atención presencial, contamos con canales físicos optimizados en todo el Perú.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm hover:shadow-md transition">
            <i class="fa-solid fa-building-columns text-red-600 text-2xl mb-4 block"></i>
            <h3 class="font-bold text-gray-900 text-lg mb-2">Agencias a Nivel Nacional</h3>
            <p class="text-gray-500 text-sm leading-relaxed">Encuentra asesoría personalizada para tus operaciones complejas o solicitudes de créditos comerciales en cualquiera de nuestras oficinas.</p>
        </div>
        <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm hover:shadow-md transition">
            <i class="fa-solid fa-money-bill-tablet-cell text-red-600 text-2xl mb-4 block"></i>
            <h3 class="font-bold text-gray-900 text-lg mb-2">Cajeros Express</h3>
            <p class="text-gray-500 text-sm leading-relaxed">Retira efectivo sin tarjeta, realiza depósitos mecánicos y paga tus tarjetas de crédito las 24 horas del día sin hacer colas.</p>
        </div>
        <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm hover:shadow-md transition">
            <i class="fa-solid fa-shop text-red-600 text-2xl mb-4 block"></i>
            <h3 class="font-bold text-gray-900 text-lg mb-2">Agentes Scotiabank</h3>
            <p class="text-gray-500 text-sm leading-relaxed">Realiza tus operaciones diarias en bodegas, farmacias y establecimientos comerciales autorizados muy cerca de tu casa.</p>
        </div>
    </div>
</section>
@endsection