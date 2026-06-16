@extends('layouts.app')

@section('titulo', 'Depósitos e Inversión')

@section('active-personas', 'text-gray-900 border-red-600')
@section('active-depositos', 'text-red-600 border-red-600 font-bold')

@section('logo-banco')
    <div class="text-red-600 font-extrabold text-3xl tracking-tight flex items-center select-none">
        <span class="bg-red-600 text-white rounded-full w-8 h-8 flex items-center justify-center text-xl mr-2 font-serif">S</span>
        Scotiabank<span class="text-gray-500 font-normal text-xs ml-1 tracking-tight uppercase">Inversiones</span>
    </div>
@endsection

@section('contenido')
<section class="relative bg-gradient-to-r from-zinc-900 via-stone-900 to-red-950 text-white min-h-[420px] flex items-center overflow-hidden border-t-4 border-red-600">
    <div class="absolute -right-10 -bottom-10 w-80 h-80 bg-red-600 rounded-full opacity-10 pointer-events-none"></div>

    <div class="max-w-6xl mx-auto px-6 w-full grid grid-cols-1 md:grid-cols-2 gap-8 items-center py-12">
        <div class="space-y-6 z-10">
            <span class="text-red-300 uppercase tracking-widest text-xs font-bold bg-red-600/20 px-3 py-1 rounded-full">Fondos Mutuos y Más</span>
            <h1 class="text-4xl md:text-5xl font-black tracking-tight leading-tight">
                Haz que tu capital <br>trabaje para ti.
            </h1>
            <p class="text-base text-gray-200">
                Accede a portafolios diversificados y opciones de inversión diseñadas por expertos globales para maximizar tus ganancias según tu perfil de riesgo.
            </p>
            <ul class="space-y-3 text-sm text-gray-300">
                <li class="flex items-center space-x-3">
                    <i class="fa-solid fa-chart-line text-red-400"></i>
                    <span>Asesoría personalizada con gestores de fondos certificados.</span>
                </li>
                <li class="flex items-center space-x-3">
                    <i class="fa-solid fa-arrow-trend-up text-red-400"></i>
                    <span>Invierte desde montos accesibles en soles o dólares de forma online.</span>
                </li>
            </ul>

            <div class="pt-2">
                <a href="#" class="bg-red-600 hover:bg-red-700 text-white font-bold px-8 py-3.5 rounded-lg text-sm shadow-xl transition inline-block">
                    Empezar a Invertir
                </a>
            </div>
        </div>

        <div class="flex justify-center md:justify-end z-10">
            <div class="bg-zinc-900 border border-zinc-800 p-6 rounded-2xl w-full max-w-sm shadow-2xl space-y-4">
                <h4 class="text-xs font-bold text-zinc-400 uppercase tracking-wider border-b border-zinc-800 pb-2">Rendimientos Históricos Recientes</h4>
                <div class="space-y-2 text-xs font-mono">
                    <div class="flex justify-between text-zinc-300"><span>Fondo Scotia Rendimiento</span> <span class="text-emerald-400 font-bold">+7.2% Anual</span></div>
                    <div class="flex justify-between text-zinc-300"><span>Fondo Scotia Acciones</span> <span class="text-emerald-400 font-bold">+11.5% Anual</span></div>
                    <div class="flex justify-between text-zinc-300"><span>Fondo Scotia Conservador</span> <span class="text-emerald-400 font-bold">+5.1% Anual</span></div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="max-w-6xl mx-auto px-6 py-16">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm">
            <h3 class="font-bold text-gray-900 text-lg mb-2">Fondos Mutuos</h3>
            <p class="text-gray-500 text-sm">Diversifica tus excedentes en mercados locales e internacionales delegando la gestión a nuestros profesionales financieros.</p>
        </div>
        <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm">
            <h3 class="font-bold text-gray-900 text-lg mb-2">Fondos de Seguro Inversión</h3>
            <p class="text-gray-500 text-sm">Protege a tu familia con un seguro de vida robusto mientras acumulas un fondo con rentabilidad atractiva a largo plazo.</p>
        </div>
        <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm">
            <h3 class="font-bold text-gray-900 text-lg mb-2">Mesa de Distribución</h3>
            <p class="text-gray-500 text-sm">Para patrimonios corporativos o personales elevados, negociamos tasas competitivas en operaciones cambiarias y pagarés.</p>
        </div>
    </div>
</section>
@endsection