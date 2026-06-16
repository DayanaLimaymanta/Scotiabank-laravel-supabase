@extends('layouts.app')

@section('titulo', 'Tarjetas de Crédito')

@section('active-personas', 'text-gray-900 border-red-600')
@section('active-tarjetas', 'text-red-600 border-red-600 font-bold')

@section('logo-banco')
    <div class="text-red-600 font-extrabold text-3xl tracking-tight flex items-center select-none">
        <span class="bg-red-600 text-white rounded-full w-8 h-8 flex items-center justify-center text-xl mr-2 font-serif">S</span>
        Scotiabank<span class="text-gray-500 font-normal text-xs ml-1 tracking-tight uppercase">Tarjetas</span>
    </div>
@endsection

@section('contenido')
<section class="relative bg-gradient-to-r from-zinc-900 via-stone-900 to-red-950 text-white min-h-[420px] flex items-center overflow-hidden border-t-4 border-red-600">
    <div class="absolute right-0 bottom-0 w-96 h-96 bg-zinc-800/30 rounded-full pointer-events-none"></div>

    <div class="max-w-6xl mx-auto px-6 w-full grid grid-cols-1 md:grid-cols-2 gap-8 items-center py-12">
        <div class="space-y-6 z-10">
            <span class="text-red-400 uppercase tracking-widest text-xs font-bold bg-zinc-800 border border-zinc-700 px-3 py-1 rounded-full">Scotiapuntos</span>
            <h1 class="text-4xl md:text-5xl font-black tracking-tight leading-tight">
                Una tarjeta diseñada <br>para cada estilo de vida.
            </h1>
            <p class="text-base text-zinc-300">
                Compra en cuotas sin intereses, acumula puntos para tus próximos viajes o recibe devoluciones de dinero en efectivo (Cashback).
            </p>
            <div class="flex flex-wrap gap-3 text-xs">
                <span class="bg-zinc-800 px-3 py-1.5 rounded-lg border border-zinc-700"><i class="fa-solid fa-plane text-red-400 mr-1.5"></i>Millas Gratis</span>
                <span class="bg-zinc-800 px-3 py-1.5 rounded-lg border border-zinc-700"><i class="fa-solid fa-basket-shopping text-red-400 mr-1.5"></i>Cuotas Sin Interés</span>
            </div>

            <div class="pt-2">
                <a href="#" class="bg-red-600 hover:bg-red-700 text-white font-bold px-8 py-3.5 rounded-lg text-sm shadow-xl transition inline-block">
                    Solicitar Tarjeta en Línea
                </a>
            </div>
        </div>

        <div class="flex justify-center md:justify-end z-10">
            <div class="w-80 h-48 bg-gradient-to-br from-zinc-700 via-zinc-800 to-black p-6 rounded-2xl shadow-2xl border border-zinc-600/30 text-white flex flex-col justify-between relative overflow-hidden transform rotate-2">
                <div class="absolute -right-10 -top-10 w-32 h-32 bg-white/5 rounded-full pointer-events-none"></div>
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-[10px] uppercase tracking-widest text-zinc-400">Visa Platinum</p>
                        <i class="fa-solid fa-microchip text-2xl text-amber-200 mt-1"></i>
                    </div>
                    <span class="font-bold text-sm tracking-tighter">Scotiabank<span class="text-red-500 font-serif">S</span></span>
                </div>
                <div>
                    <p class="text-sm tracking-widest font-mono mb-1">**** **** **** 4826</p>
                    <div class="flex justify-between items-center text-[10px] text-zinc-400">
                        <span>JUAN PEREZ M.</span>
                        <span>VENCE 12/30</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="max-w-6xl mx-auto px-6 py-16">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <div class="p-6 bg-zinc-50 border border-zinc-100 rounded-xl">
            <h4 class="font-bold text-zinc-900 text-base mb-2">Tarjeta Visa Access</h4>
            <p class="text-xs text-zinc-500 leading-relaxed">Sin costo de membresía anual realizando consumos mínimos mensuales. Ideal para compras del día a día.</p>
        </div>
        <div class="p-6 bg-zinc-50 border border-zinc-100 rounded-xl">
            <h4 class="font-bold text-zinc-900 text-base mb-2">Visa Smart / Gold</h4>
            <p class="text-xs text-zinc-500 leading-relaxed">Acumula doble puntaje en las categorías de streaming, apps de delivery y supermercados nacionales.</p>
        </div>
        <div class="p-6 bg-zinc-50 border border-zinc-100 rounded-xl">
            <h4 class="font-bold text-zinc-900 text-base mb-2">Mastercard Black</h4>
            <p class="text-xs text-zinc-500 leading-relaxed">Acceso exclusivo a salas VIP en aeropuertos internacionales, seguros de viaje globales y asistencia premium 24/7.</p>
        </div>
    </div>
</section>
@endsection