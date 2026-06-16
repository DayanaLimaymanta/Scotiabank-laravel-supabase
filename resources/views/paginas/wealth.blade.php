@extends('layouts.app')

@section('titulo', 'Wealth Management')

@section('active-wealth', 'text-gray-900 border-emerald-600')

@section('logo-banco')
<div class="text-slate-900 font-extrabold text-3xl tracking-tight flex items-center select-none">
    <span class="bg-emerald-800 text-white rounded-full w-8 h-8 flex items-center justify-center text-xl mr-2 font-serif">S</span>
    Scotiabank<span class="text-emerald-700 font-light text-xs ml-1 tracking-tight">Wealth Management</span>
</div>
@endsection

@section('contenido')
<section class="relative bg-gradient-to-r from-emerald-950 via-teal-900 to-slate-900 text-white min-h-[420px] flex items-center overflow-hidden border-t-4 border-emerald-600">
    <div class="absolute right-0 top-0 w-80 h-full bg-gradient-to-l from-white/5 to-transparent pointer-events-none"></div>

    <div class="max-w-6xl mx-auto px-6 w-full grid grid-cols-1 md:grid-cols-2 gap-8 items-center py-12">
        <div class="space-y-6 z-10">
            <span class="text-emerald-400 uppercase tracking-widest text-xs font-bold bg-emerald-400/10 px-3 py-1 rounded-full">Gestión Patrimonial Global</span>
            <h1 class="text-4xl md:text-5xl font-black tracking-tight leading-tight">
                Protegemos y hacemos <br><span class="text-emerald-400">crecer tu legado.</span>
            </h1>
            <p class="text-base text-emerald-100/80">
                Soluciones sofisticadas de inversión internacional, planificación sucesoria corporativa y corretaje de alta gama respaldado por una red global con presencia en los principales mercados del mundo.
            </p>
            
            <div class="flex flex-wrap gap-4 text-xs font-semibold uppercase tracking-wider text-emerald-300">
                <span class="bg-emerald-900/40 border border-emerald-800 px-3 py-1.5 rounded">Fondos Globales</span>
                <span class="bg-emerald-900/40 border border-emerald-800 px-3 py-1.5 rounded">Asesoría Offshore</span>
                <span class="bg-emerald-900/40 border border-emerald-800 px-3 py-1.5 rounded">Banca Custodia</span>
            </div>

            <div class="pt-2">
                <a href="#" class="bg-emerald-500 hover:bg-emerald-600 text-slate-950 font-bold px-8 py-3.5 rounded-lg text-sm shadow-xl transition inline-block">
                    Contactar a un Consultor
                </a>
            </div>
        </div>

        <div class="flex justify-center md:justify-end z-10">
            <div class="bg-slate-900/80 backdrop-blur-md border border-emerald-500/20 p-6 rounded-2xl w-full max-w-sm shadow-2xl">
                <div class="flex justify-between items-center mb-4">
                    <h4 class="text-xs font-bold text-emerald-400 uppercase tracking-wide">Rendimiento Portafolio</h4>
                    <span class="text-[10px] text-zinc-400">Global Equities</span>
                </div>
                <div class="space-y-3">
                    <div>
                        <div class="flex justify-between text-xs mb-1">
                            <span class="text-zinc-300">Fondo Moderado Internacional</span>
                            <span class="font-bold text-emerald-400">+12.4%</span>
                        </div>
                        <div class="w-full bg-zinc-800 h-1.5 rounded-full">
                            <div class="bg-emerald-500 h-1.5 rounded-full" style="width: 75%"></div>
                        </div>
                    </div>
                    <div>
                        <div class="flex justify-between text-xs mb-1">
                            <span class="text-zinc-300">Fondo Crecimiento Agresivo</span>
                            <span class="font-bold text-emerald-400">+18.7%</span>
                        </div>
                        <div class="w-full bg-zinc-800 h-1.5 rounded-full">
                            <div class="bg-emerald-400 h-1.5 rounded-full" style="width: 90%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="max-w-6xl mx-auto px-6 py-16 bg-zinc-50 border-y border-zinc-100">
    <h3 class="text-center text-sm uppercase tracking-widest font-bold text-zinc-400 mb-10">Nuestra estrategia de acompañamiento</h3>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white p-5 rounded-xl border border-zinc-200/60 shadow-sm">
            <i class="fa-solid fa-earth-americas text-emerald-600 text-lg mb-3"></i>
            <h4 class="font-bold text-sm text-gray-900 mb-1">Diversificación Global</h4>
            <p class="text-xs text-gray-500 leading-relaxed">Mitigación de riesgos operando en múltiples divisas y jurisdicciones estables.</p>
        </div>
        <div class="bg-white p-5 rounded-xl border border-zinc-200/60 shadow-sm">
            <i class="fa-solid fa-scale-balanced text-emerald-600 text-lg mb-3"></i>
            <h4 class="font-bold text-sm text-gray-900 mb-1">Planificación Fiscal</h4>
            <p class="text-xs text-gray-500 leading-relaxed">Estructuración impositiva eficiente para empresas familiares y patrimonios.</p>
        </div>
        <div class="bg-white p-5 rounded-xl border border-zinc-200/60 shadow-sm">
            <i class="fa-solid fa-chart-line text-emerald-600 text-lg mb-3"></i>
            <h4 class="font-bold text-sm text-gray-900 mb-1">Arquitectura Abierta</h4>
            <p class="text-xs text-gray-500 leading-relaxed">Acceso a los mejores fondos del mercado, sean o no propios del grupo Scotiabank.</p>
        </div>
        <div class="bg-white p-5 rounded-xl border border-zinc-200/60 shadow-sm">
            <i class="fa-solid fa-file-shield text-emerald-600 text-lg mb-3"></i>
            <h4 class="font-bold text-sm text-gray-900 mb-1">Confidencialidad</h4>
            <p class="text-xs text-gray-500 leading-relaxed">Protocolos de seguridad de alto nivel para resguardar la privacidad de tus activos.</p>
        </div>
    </div>
</section>
@endsection