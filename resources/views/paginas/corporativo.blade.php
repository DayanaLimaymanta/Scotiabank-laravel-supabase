@extends('layouts.app')

@section('titulo', 'Grandes Empresas')

@section('active-corporativo', 'text-gray-900 border-zinc-700')

@section('logo-banco')
<div class="text-zinc-900 font-extrabold text-3xl tracking-tight flex items-center select-none">
    <span class="bg-zinc-800 text-white rounded-full w-8 h-8 flex items-center justify-center text-xl mr-2 font-serif">S</span>
    Scotiabank<span class="text-zinc-600 font-normal text-xs ml-1 tracking-tight uppercase">Corporativo</span>
</div>
@endsection

@section('contenido')
<section class="relative bg-gradient-to-r from-zinc-950 via-slate-900 to-zinc-900 text-white min-h-[420px] flex items-center overflow-hidden border-t-4 border-zinc-700">
    <div class="absolute right-0 bottom-0 w-96 h-96 bg-gradient-to-tl from-zinc-800/20 to-transparent rounded-full pointer-events-none"></div>

    <div class="max-w-6xl mx-auto px-6 w-full grid grid-cols-1 md:grid-cols-2 gap-8 items-center py-12">
        <div class="space-y-6 z-10">
            <span class="text-zinc-400 uppercase tracking-widest text-xs font-bold bg-zinc-800 border border-zinc-700 px-3 py-1 rounded-full">Banca Corporativa Global</span>
            <h1 class="text-4xl md:text-5xl font-black tracking-tight leading-tight">
                Soluciones globales de <br><span class="text-zinc-400">alta envergadura.</span>
            </h1>
            <p class="text-base text-zinc-300">
                Estructuración de créditos sindicados, financiamiento de proyectos macro, comercio exterior inteligente y servicios de tesorería automatizada a gran escala.
            </p>
            
            <div class="flex flex-wrap gap-4 text-xs font-mono text-zinc-400">
                <span class="bg-zinc-900 px-2 py-1 rounded border border-zinc-800"><i class="fa-solid fa-network-wired text-zinc-500 mr-1.5"></i>Cash Management</span>
                <span class="bg-zinc-900 px-2 py-1 rounded border border-zinc-800"><i class="fa-solid fa-money-bill-transfer text-zinc-500 mr-1.5"></i>Trade Finance</span>
            </div>

            <div class="pt-2">
                <a href="#" class="bg-zinc-700 hover:bg-zinc-600 text-white font-bold px-8 py-3.5 rounded-lg text-sm shadow-xl transition inline-block tracking-wide">
                    Contactar Banca Corporativa
                </a>
            </div>
        </div>

        <div class="flex justify-center md:justify-end z-10">
            <div class="bg-zinc-900 border border-zinc-800 p-6 rounded-2xl w-full max-w-sm shadow-2xl space-y-4">
                <h4 class="text-xs font-bold text-zinc-400 uppercase tracking-wider border-b border-zinc-800 pb-2">Mercado de Capitales</h4>
                <div class="space-y-2 text-xs font-mono">
                    <div class="flex justify-between text-zinc-300"><span>Emisión de Bonos</span> <span class="text-emerald-400 font-bold">Completado</span></div>
                    <div class="flex justify-between text-zinc-300"><span>Financiamiento Corporativo</span> <span class="text-emerald-400 font-bold">Activo</span></div>
                    <div class="flex justify-between text-zinc-300"><span>M&A Asesoría</span> <span class="text-zinc-500">En proceso</span></div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="max-w-6xl mx-auto px-6 py-16">
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
        <div class="p-6 bg-zinc-50 border border-zinc-100 rounded-xl">
            <h4 class="font-bold text-zinc-900 text-base mb-2">Mesa de Dinero Internacional</h4>
            <p class="text-xs text-zinc-500 leading-relaxed">Operaciones cambiarias a gran escala, forwards, opciones y coberturas de derivados financieros en tiempo real.</p>
        </div>
        <div class="p-6 bg-zinc-50 border border-zinc-100 rounded-xl">
            <h4 class="font-bold text-zinc-900 text-base mb-2">Soluciones de Recaudación</h4>
            <p class="text-xs text-zinc-500 leading-relaxed">Conexión por API y Host-to-Host directa para automatizar la cobranza masiva e integrarse con el ERP de tu corporación.</p>
        </div>
        <div class="p-6 bg-zinc-50 border border-zinc-100 rounded-xl">
            <h4 class="font-bold text-zinc-900 text-base mb-2">Banca de Inversión</h4>
            <p class="text-xs text-zinc-500 leading-relaxed">Asesoría especializada en fusiones, adquisiciones, reestructuración de deuda corporativa y salida a bolsa corporativa.</p>
        </div>
    </div>
</section>
@endsection