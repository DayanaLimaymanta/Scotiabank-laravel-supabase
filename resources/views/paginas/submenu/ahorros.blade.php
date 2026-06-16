@extends('layouts.app')

@section('titulo', 'Cuentas de Ahorros')

@section('active-personas', 'text-gray-900 border-red-600')
@section('active-ahorros', 'text-red-600 border-red-600 font-bold')

@section('logo-banco')
    <div class="text-red-600 font-extrabold text-3xl tracking-tight flex items-center select-none">
        <span class="bg-red-600 text-white rounded-full w-8 h-8 flex items-center justify-center text-xl mr-2 font-serif">S</span>
        Scotiabank<span class="text-gray-500 font-normal text-xs ml-1 tracking-tight uppercase">Ahorros</span>
    </div>
@endsection

@section('contenido')
<section class="relative bg-gradient-to-r from-zinc-900 via-red-950 to-red-800 text-white min-h-[420px] flex items-center overflow-hidden border-t-4 border-red-600">
    <div class="absolute -right-10 -top-10 w-80 h-80 bg-red-600 rounded-full opacity-10 pointer-events-none"></div>

    <div class="max-w-6xl mx-auto px-6 w-full grid grid-cols-1 md:grid-cols-2 gap-8 items-center py-12">
        <div class="space-y-6 z-10">
            <span class="text-red-300 uppercase tracking-widest text-xs font-bold bg-red-600/20 px-3 py-1 rounded-full">Cero Mantenimiento</span>
            <h1 class="text-4xl md:text-5xl font-black tracking-tight leading-tight">
                Tu dinero crece seguro <br>y sin condiciones.
            </h1>
            <p class="text-base text-gray-200">
                Abre tu Cuenta Digital 100% online en solo 3 minutos. Disfruta de una Súper Tasa de interés y maneja tus ahorros sin cobros ocultos.
            </p>
            <ul class="space-y-3 text-sm text-gray-300">
                <li class="flex items-center space-x-3">
                    <i class="fa-solid fa-percent text-red-400"></i>
                    <span>Tasa de interés preferencial para dinero nuevo.</span>
                </li>
                <li class="flex items-center space-x-3">
                    <i class="fa-solid fa-ban text-red-400"></i>
                    <span>Siles u órdenes de pago ilimitadas sin costo adicional.</span>
                </li>
            </ul>

            <div class="pt-2">
                <a href="{{ route('register') }}" class="bg-red-600 hover:bg-red-700 text-white font-bold px-8 py-3.5 rounded-lg text-sm shadow-xl transition inline-block">
                    Abrir Cuenta de Ahorros
                </a>
            </div>
        </div>

        <div class="flex justify-center md:justify-end z-10">
            <div class="bg-zinc-900/90 border border-zinc-800 p-6 rounded-2xl w-full max-w-sm shadow-2xl text-white">
                <div class="flex justify-between items-center mb-4">
                    <h4 class="text-xs font-bold text-zinc-400 uppercase tracking-wider">Simulador de Plazo Fijo</h4>
                    <span class="text-[10px] bg-red-500/20 text-red-400 px-2 py-0.5 rounded font-mono font-bold">TREA 6.5%</span>
                </div>
                <div class="space-y-3 text-sm">
                    <div class="bg-zinc-800/40 p-3 rounded-xl border border-zinc-700/50 flex justify-between">
                        <span class="text-zinc-400">Si dejas:</span>
                        <span class="font-bold text-white">S/ 10,000</span>
                    </div>
                    <div class="bg-zinc-800/40 p-3 rounded-xl border border-zinc-700/50 flex justify-between">
                        <span class="text-zinc-400">Por un lapso de:</span>
                        <span class="font-bold text-white">360 días</span>
                    </div>
                    <div class="pt-2 border-t border-zinc-800 flex justify-between items-center">
                        <span class="text-xs text-zinc-400">Ganancia Estimada:</span>
                        <span class="text-lg font-bold text-emerald-400">S/ 650.00</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="max-w-6xl mx-auto px-6 py-16">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm">
            <i class="fa-solid fa-wallet text-red-600 text-2xl mb-4 block"></i>
            <h3 class="font-bold text-gray-900 text-lg mb-2">Cuenta Digital</h3>
            <p class="text-gray-500 text-sm">Ideal para tus transacciones del día a día. Sin cobro de mantenimiento y transferencias interbancarias gratis.</p>
        </div>
        <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm">
            <i class="fa-solid fa-piggy-bank text-red-600 text-2xl mb-4 block"></i>
            <h3 class="font-bold text-gray-900 text-lg mb-2">Cuenta Sueldo</h3>
            <p class="text-gray-500 text-sm">Recibe tu sueldo aquí y accede a descuentos de hasta 50% en restaurantes, cines y establecimientos seleccionados.</p>
        </div>
        <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm">
            <i class="fa-solid fa-vault text-red-600 text-2xl mb-4 block"></i>
            <h3 class="font-bold text-gray-900 text-lg mb-2">Depósito a Plazo Fijo</h3>
            <p class="text-gray-500 text-sm">Asegura un rendimiento alto dejando tus ahorros a un plazo determinado con total tranquilidad y respaldo.</p>
        </div>
    </div>
</section>
@endsection