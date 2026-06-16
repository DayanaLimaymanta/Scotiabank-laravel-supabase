@extends('layouts.app')

@section('titulo', 'Quiénes Somos')

@section('active-nosotros', 'text-gray-900 border-zinc-400')

@section('logo-banco')
<div class="text-red-600 font-extrabold text-3xl tracking-tight flex items-center select-none">
    <span class="bg-red-600 text-white rounded-full w-8 h-8 flex items-center justify-center text-xl mr-2 font-serif">S</span>
    Scotiabank<span class="text-zinc-500 font-light text-xs ml-1 tracking-wider uppercase">Institucional</span>
</div>
@endsection

@section('contenido')
<section class="relative bg-zinc-100 text-zinc-900 min-h-[380px] flex items-center overflow-hidden border-t-4 border-zinc-300">
    <div class="max-w-4xl mx-auto px-6 w-full text-center py-12 space-y-4">
        <span class="text-red-600 uppercase tracking-widest text-xs font-bold bg-red-50 px-3 py-1 rounded-full">Nuestro Compromiso</span>
        <h1 class="text-4xl md:text-5xl font-black tracking-tight text-zinc-900">
            Por nuestro futuro, <br><span class="text-zinc-600 font-light">cada día.</span>
        </h1>
        <p class="text-base text-zinc-600 max-w-xl mx-auto leading-relaxed">
            Como un banco líder en las Américas, trabajamos con pasión para ayudar a nuestros clientes, sus familias y sus comunidades a alcanzar el éxito financiero de manera sostenible.
        </p>
    </div>
</section>

<section class="max-w-5xl mx-auto px-6 py-16">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-12 text-center">
        <div class="space-y-2">
            <div class="w-12 h-12 bg-red-50 text-red-600 rounded-full flex items-center justify-center text-xl mx-auto mb-2">
                <i class="fa-solid fa-handshake-angle"></i>
            </div>
            <h3 class="font-bold text-zinc-900 text-base">Integridad</h3>
            <p class="text-xs text-zinc-500 leading-relaxed">Actuamos siempre bajo los estándares éticos más altos, garantizando la transparencia absoluta en cada transacción.</p>
        </div>
        <div class="space-y-2">
            <div class="w-12 h-12 bg-red-50 text-red-600 rounded-full flex items-center justify-center text-xl mx-auto mb-2">
                <i class="fa-solid fa-users"></i>
            </div>
            <h3 class="font-bold text-zinc-900 text-base">Inclusión</h3>
            <p class="text-xs text-zinc-500 leading-relaxed">Fomentamos un entorno diverso donde todas las personas tengan las mismas oportunidades de desarrollo económico.</p>
        </div>
        <div class="space-y-2">
            <div class="w-12 h-12 bg-red-50 text-red-600 rounded-full flex items-center justify-center text-xl mx-auto mb-2">
                <i class="fa-solid fa-lightbulb"></i>
            </div>
            <h3 class="font-bold text-zinc-900 text-base">Innovación</h3>
            <p class="text-xs text-zinc-500 leading-relaxed">Evolucionamos digitalmente de manera constante para ofrecer herramientas ágiles, seguras y eficientes a nuestros usuarios.</p>
        </div>
    </div>
</section>
@endsection