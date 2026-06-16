@extends('layouts.app')

@section('titulo', 'Singular')

@section('active-singular', 'text-gray-900 border-yellow-600')

@section('logo-banco')
<div class="text-slate-900 font-extrabold text-3xl tracking-tight flex items-center select-none">
    <span class="bg-slate-900 text-yellow-500 rounded-full w-8 h-8 flex items-center justify-center text-xl mr-2 font-serif border border-yellow-500/30">S</span>
    Scotiabank<span class="text-yellow-600 font-medium text-xs ml-1 tracking-widest uppercase">Singular</span>
</div>
@endsection

@section('contenido')
<section class="relative bg-gradient-to-r from-slate-900 via-slate-800 to-zinc-900 text-white min-h-[420px] flex items-center overflow-hidden border-t-4 border-yellow-500">
    <div class="absolute -right-16 -bottom-16 w-96 h-96 bg-yellow-500 rounded-full opacity-5 pointer-events-none"></div>

    <div class="max-w-6xl mx-auto px-6 w-full grid grid-cols-1 md:grid-cols-2 gap-8 items-center py-12">
        <div class="space-y-6 z-10">
            <span class="text-yellow-500 uppercase tracking-widest text-xs font-bold bg-yellow-500/10 px-3 py-1 rounded-full">Experiencia Exclusiva</span>
            <h1 class="text-4xl md:text-5xl font-light tracking-tight leading-tight">
                Diseñado para ir <br><span class="font-black text-yellow-500">más allá de tus metas.</span>
            </h1>
            <p class="text-base text-slate-300">
                Disfruta de asesoría financiera personalizada, tasas exclusivas en fondos de inversión y una atención prioritaria en canales preferentes.
            </p>
            
            <ul class="space-y-3 text-sm text-slate-400">
                <li class="flex items-center space-x-3">
                    <i class="fa-solid fa-gem text-yellow-500"></i>
                    <span>Acceso ilimitado a Salas VIP en aeropuertos internacionales.</span>
                </li>
                <li class="flex items-center space-x-3">
                    <i class="fa-solid fa-user-tie text-yellow-500"></i>
                    <span>Asesor de inversión senior asignado de forma exclusiva.</span>
                </li>
            </ul>

            <div class="pt-2">
                <a href="#" class="bg-yellow-500 hover:bg-yellow-600 text-slate-950 font-bold px-8 py-3.5 rounded-lg text-sm shadow-xl transition inline-block tracking-wide">
                    Solicitar Invitación
                </a>
            </div>
        </div>

        <div class="flex justify-center md:justify-end z-10">
            <div class="w-80 h-48 bg-gradient-to-br from-zinc-800 to-black p-6 rounded-2xl shadow-2xl border border-zinc-700/50 relative overflow-hidden flex flex-col justify-between transform hover:rotate-2 transition">
                <div class="absolute top-0 right-0 w-32 h-32 bg-yellow-500/5 rounded-full blur-xl"></div>
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-[10px] uppercase text-zinc-400 tracking-widest font-bold">Singular Metal</p>
                        <i class="fa-solid fa-microchip text-zinc-400 text-2xl mt-1"></i>
                    </div>
                    <span class="text-yellow-500/80 font-serif text-2xl italic font-bold">S</span>
                </div>
                <div>
                    <p class="text-sm tracking-widest text-zinc-300 font-mono">•••• •••• •••• 8892</p>
                    <p class="text-[9px] uppercase text-zinc-500 tracking-wider mt-1">S. CIPRIANI</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="max-w-6xl mx-auto px-6 py-16">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <div class="border-l-2 border-yellow-500 pl-4">
            <h3 class="font-bold text-gray-900 text-base mb-1">Tasas de Élite</h3>
            <p class="text-xs text-gray-500">Condiciones preferenciales en créditos hipotecarios y depósitos a plazo fijo.</p>
        </div>
        <div class="border-l-2 border-yellow-500 pl-4">
            <h3 class="font-bold text-gray-900 text-base mb-1">Eventos Privados</h3>
            <p class="text-xs text-gray-500">Invitaciones a catas exclusivas, preventas artísticas y conferencias de economía.</p>
        </div>
        <div class="border-l-2 border-yellow-500 pl-4">
            <h3 class="font-bold text-gray-900 text-base mb-1">Línea Preferente</h3>
            <p class="text-xs text-gray-500">Atención telefónica directa en menos de 20 segundos sin pasar por menús interactivos.</p>
        </div>
    </div>
</section>
@endsection