@extends('layouts.app')

@section('titulo', 'Programas de Lealtad')

@section('active-personas', 'text-gray-900 border-red-600')
@section('active-lealtad', 'text-red-600 border-red-600 font-bold')

@section('logo-banco')
    <div class="text-red-600 font-extrabold text-3xl tracking-tight flex items-center select-none">
        <span class="bg-red-600 text-white rounded-full w-8 h-8 flex items-center justify-center text-xl mr-2 font-serif">S</span>
        Scotiabank<span class="text-gray-500 font-normal text-xs ml-1 tracking-tight uppercase">Beneficios</span>
    </div>
@endsection

@section('contenido')
<section class="relative bg-gradient-to-r from-zinc-900 via-red-950 to-red-900 text-white min-h-[420px] flex items-center overflow-hidden border-t-4 border-red-600">
    <div class="absolute -left-10 -top-10 w-80 h-80 bg-red-600 rounded-full opacity-10 pointer-events-none"></div>

    <div class="max-w-6xl mx-auto px-6 w-full grid grid-cols-1 md:grid-cols-2 gap-8 items-center py-12">
        <div class="space-y-6 z-10">
            <span class="text-red-300 uppercase tracking-widest text-xs font-bold bg-red-600/20 px-3 py-1 rounded-full">Club Scotiabank</span>
            <h1 class="text-4xl md:text-5xl font-black tracking-tight leading-tight">
                Tus consumos diarios <br>se convierten en premios.
            </h1>
            <p class="text-base text-gray-200">
                Acumula puntos por cada sol de consumo con tus tarjetas de débito o crédito y canjéalos de inmediato por pasajes, productos tecnológicos o cashback.
            </p>
            <ul class="space-y-3 text-sm text-gray-300">
                <li class="flex items-center space-x-3">
                    <i class="fa-solid fa-gift text-red-400"></i>
                    <span>Catálogo digital exclusivo con más de 500 productos seleccionados.</span>
                </li>
                <li class="flex items-center space-x-3">
                    <i class="fa-solid fa-tags text-red-400"></i>
                    <span>Descuentos inmediatos en comercios asociados solo mostrando tu App.</span>
                </li>
            </ul>

            <div class="pt-2">
                <a href="#" class="bg-red-600 hover:bg-red-700 text-white font-bold px-8 py-3.5 rounded-lg text-sm shadow-xl transition inline-block">
                    Ver Catálogo de Premios
                </a>
            </div>
        </div>

        <div class="flex justify-center md:justify-end z-10">
            <div class="bg-zinc-900 border border-zinc-800 p-6 rounded-2xl w-full max-w-sm shadow-2xl text-center space-y-3">
                <div class="text-amber-400 text-3xl"><i class="fa-solid fa-star"></i></div>
                <p class="text-xs uppercase text-zinc-400 tracking-wider">Tu Estado de Puntos</p>
                <h4 class="text-2xl font-black text-white tracking-tight">14,250 <span class="text-xs text-zinc-500 font-normal">Puntos</span></h4>
                <div class="w-full bg-zinc-800 h-1.5 rounded-full overflow-hidden">
                    <div class="bg-gradient-to-r from-red-500 to-amber-500 h-full w-3/4"></div>
                </div>
                <p class="text-[10px] text-zinc-500 font-mono">¡Estás muy cerca de tu próximo pasaje nacional!</p>
            </div>
        </div>
    </div>
</section>

<section class="max-w-6xl mx-auto px-6 py-16">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm">
            <h3 class="font-bold text-gray-900 text-base mb-2">Canje de Productos</h3>
            <p class="text-gray-500 text-xs leading-relaxed">Cambia tus puntos acumulados por lo último en tecnología, electrodomésticos para el hogar o vales de consumo digital en supermercados.</p>
        </div>
        <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm">
            <h3 class="font-bold text-gray-900 text-base mb-2">Viajes y Experiencias</h3>
            <p class="text-gray-500 text-xs leading-relaxed">Usa tus puntos para comprar pasajes aéreos en cualquier aerolínea, reservar hoteles o adquirir paquetes turísticos sin restricciones de fechas.</p>
        </div>
        <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm">
            <h3 class="font-bold text-gray-900 text-base mb-2">Scotia Cashback</h3>
            <p class="text-gray-500 text-xs leading-relaxed">¿Prefieres el dinero? Convierte tus puntos acumulados directamente en saldo a favor en soles para tu Tarjeta de Crédito de forma inmediata.</p>
        </div>
    </div>
</section>
@endsection