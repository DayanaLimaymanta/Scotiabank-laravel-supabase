@extends('layouts.app')

@section('titulo', 'Seguros y Protección')

@section('active-personas', 'text-gray-900 border-red-600')
@section('active-seguros', 'text-red-600 border-red-600 font-bold')

@section('logo-banco')
    <div class="text-red-600 font-extrabold text-3xl tracking-tight flex items-center select-none">
        <span class="bg-red-600 text-white rounded-full w-8 h-8 flex items-center justify-center text-xl mr-2 font-serif">S</span>
        Scotiabank<span class="text-gray-500 font-normal text-xs ml-1 tracking-tight uppercase">Seguros</span>
    </div>
@endsection

@section('contenido')
<section class="relative bg-gradient-to-r from-red-900 to-zinc-900 text-white min-h-[420px] flex items-center overflow-hidden border-t-4 border-red-600">
    <div class="absolute right-0 bottom-0 w-96 h-96 bg-zinc-800/20 rounded-full pointer-events-none"></div>

    <div class="max-w-6xl mx-auto px-6 w-full grid grid-cols-1 md:grid-cols-2 gap-8 items-center py-12">
        <div class="space-y-6 z-10">
            <span class="text-red-300 uppercase tracking-widest text-xs font-bold bg-red-600/20 px-3 py-1 rounded-full">Respaldo Total</span>
            <h1 class="text-4xl md:text-5xl font-black tracking-tight leading-tight">
                Protege lo que más <br>valoras en la vida.
            </h1>
            <p class="text-base text-gray-200">
                Duerme con total tranquilidad contratando nuestras pólizas flexibles con coberturas completas ante imprevistos, accidentes o emergencias de salud.
            </p>
            <ul class="space-y-3 text-sm text-gray-300">
                <li class="flex items-center space-x-3">
                    <i class="fa-solid fa-clock text-red-400"></i>
                    <span>Asistencia médica y vehicular en ruta las 24 horas del día.</span>
                </li>
                <li class="flex items-center space-x-3">
                    <i class="fa-solid fa-file-shield text-red-400"></i>
                    <span>Procesos de indemnización rápidos, transparentes y sin trabas.</span>
                </li>
            </ul>

            <div class="pt-2">
                <a href="#" class="bg-red-600 hover:bg-red-700 text-white font-bold px-8 py-3.5 rounded-lg text-sm shadow-xl transition inline-block">
                    Cotizar un Seguro Seguro
                </a>
            </div>
        </div>

        <div class="flex justify-center md:justify-end z-10">
            <div class="w-80 bg-zinc-900 border border-zinc-800 p-5 rounded-2xl shadow-2xl flex flex-col justify-between">
                <div class="flex items-center space-x-3 mb-4">
                    <div class="w-10 h-10 bg-emerald-500/10 text-emerald-400 rounded-lg flex items-center justify-center">
                        <i class="fa-solid fa-shield-heart text-lg"></i>
                    </div>
                    <div>
                        <h4 class="text-xs font-bold text-white">Seguro de Vida Activo</h4>
                        <p class="text-[10px] text-zinc-500">Póliza N° #82634-A</p>
                    </div>
                </div>
                <div class="text-xs text-zinc-400 space-y-1.5 font-mono border-t border-zinc-800 pt-3">
                    <div class="flex justify-between"><span>Soporte Médico:</span> <span class="text-white">Ilimitado</span></div>
                    <div class="flex justify-between"><span>Cobertura Nacional:</span> <span class="text-white">100%</span></div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="max-w-6xl mx-auto px-6 py-16">
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
        <div class="p-6 bg-zinc-50 border border-zinc-100 rounded-xl hover:shadow-sm transition">
            <h4 class="font-bold text-zinc-900 text-base mb-2">Seguro Vehicular</h4>
            <p class="text-xs text-zinc-500 leading-relaxed">Cobertura total contra choques, robos de autopartes, chofer de reemplazo y auxilio mecánico inmediato.</p>
        </div>
        <div class="p-6 bg-zinc-50 border border-zinc-100 rounded-xl hover:shadow-sm transition">
            <h4 class="font-bold text-zinc-900 text-base mb-2">Protección de Tarjetas</h4>
            <p class="text-xs text-zinc-500 leading-relaxed">Blindaje contra fraude digital, clonación, compras no reconocidas físicas y robos en cajeros automáticos.</p>
        </div>
        <div class="p-6 bg-zinc-50 border border-zinc-100 rounded-xl hover:shadow-sm transition">
            <h4 class="font-bold text-zinc-900 text-base mb-2">Seguro de Salud Integral</h4>
            <p class="text-xs text-zinc-500 leading-relaxed">Acceso a las mejores clínicas privadas del país, consultas médicas online gratis y descuentos en farmacias.</p>
        </div>
    </div>
</section>
@endsection