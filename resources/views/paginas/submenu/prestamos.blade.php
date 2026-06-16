@extends('layouts.app')

@section('titulo', 'Préstamos Personales')

@section('active-personas', 'text-gray-900 border-red-600')
@section('active-prestamos', 'text-red-600 border-red-600 font-bold')

@section('logo-banco')
    <div class="text-red-600 font-extrabold text-3xl tracking-tight flex items-center select-none">
        <span class="bg-red-600 text-white rounded-full w-8 h-8 flex items-center justify-center text-xl mr-2 font-serif">S</span>
        Scotiabank<span class="text-gray-500 font-normal text-xs ml-1 tracking-tight uppercase">Préstamos</span>
    </div>
@endsection

@section('contenido')
<section class="relative bg-gradient-to-r from-red-900 to-zinc-900 text-white min-h-[420px] flex items-center overflow-hidden border-t-4 border-red-600">
    <div class="absolute -left-10 -bottom-10 w-80 h-80 bg-red-600 rounded-full opacity-10 pointer-events-none"></div>

    <div class="max-w-6xl mx-auto px-6 w-full grid grid-cols-1 md:grid-cols-2 gap-8 items-center py-12">
        <div class="space-y-6 z-10">
            <span class="text-red-300 uppercase tracking-widest text-xs font-bold bg-red-600/20 px-3 py-1 rounded-full">Aprobación Inmediata</span>
            <h1 class="text-4xl md:text-5xl font-black tracking-tight leading-tight">
                Haz realidad tus planes <br>con efectivo al instante.
            </h1>
            <p class="text-base text-gray-200">
                Financia tus proyectos, consolida tus deudas pesadas o renueva tu hogar con tasas preferenciales exclusivas para clientes del banco.
            </p>
            <ul class="space-y-3 text-sm text-gray-300">
                <li class="flex items-center space-x-3">
                    <i class="fa-solid fa-calendar-days text-red-400"></i>
                    <span>Paga tu primera cuota hasta en 90 días después de desembolsar.</span>
                </li>
                <li class="flex items-center space-x-3">
                    <i class="fa-solid fa-handshake text-red-400"></i>
                    <span>Sin penalizaciones ni cobros por amortizaciones parciales o totales.</span>
                </li>
            </ul>

            <div class="pt-2">
                <a href="#" class="bg-red-600 hover:bg-red-700 text-white font-bold px-8 py-3.5 rounded-lg text-sm shadow-xl transition inline-block">
                    Solicitar Préstamo Efectivo
                </a>
            </div>
        </div>

        <div class="flex justify-center md:justify-end z-10">
            <div class="bg-zinc-900 border border-zinc-800 p-6 rounded-2xl w-full max-w-sm shadow-2xl space-y-4">
                <h4 class="text-xs font-bold text-zinc-400 uppercase tracking-wider border-b border-zinc-800 pb-2">Líneas de Crédito Disponibles</h4>
                <div class="space-y-2 text-xs font-mono">
                    <div class="flex justify-between text-zinc-300"><span>Préstamo Vehicular</span> <span class="text-emerald-400 font-bold">Pre-aprobado</span></div>
                    <div class="flex justify-between text-zinc-300"><span>Préstamo Hipotecario</span> <span class="text-zinc-400">Sujeto a Evaluación</span></div>
                    <div class="flex justify-between text-zinc-300"><span>Estudios de Postgrado</span> <span class="text-emerald-400 font-bold">Pre-aprobado</span></div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="max-w-6xl mx-auto px-6 py-16">
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
        <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm hover:shadow-md transition">
            <h4 class="font-bold text-gray-900 text-lg mb-2">Préstamo Personal</h4>
            <p class="text-gray-500 text-sm">Efectivo de libre disponibilidad desde S/ 1,000 hasta S/ 100,000 con plazos flexibles de hasta 60 meses.</p>
        </div>
        <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm hover:shadow-md transition">
            <h4 class="font-bold text-gray-900 text-lg mb-2">Compra de Deuda</h4>
            <p class="text-gray-500 text-sm">Consolida todas las deudas que tengas con tarjetas de otros bancos en una sola cuota mensual fija y menor.</p>
        </div>
        <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm hover:shadow-md transition">
            <h4 class="font-bold text-gray-900 text-lg mb-2">Crédito Hipotecario</h4>
            <p class="text-gray-500 text-sm">Financia hasta el 90% del valor de tu primera vivienda con plazos extendidos de pago de hasta 25 años.</p>
        </div>
    </div>
</section>
@endsection