@extends('layouts.app')

@section('titulo', 'Negocios')

@section('active-negocios', 'text-gray-900 border-blue-600')

@section('logo-banco')
<div class="text-blue-900 font-extrabold text-3xl tracking-tight flex items-center select-none">
    <span class="bg-blue-600 text-white rounded-full w-8 h-8 flex items-center justify-center text-xl mr-2 font-serif">S</span>
    Scotiabank<span class="text-blue-600 font-bold text-xs ml-1 tracking-wider uppercase">Negocios</span>
</div>
@endsection

@section('contenido')
<section class="relative bg-gradient-to-r from-blue-900 via-blue-800 to-indigo-950 text-white min-h-[420px] flex items-center overflow-hidden border-t-4 border-blue-500">
    <div class="absolute -left-10 -top-10 w-80 h-80 bg-blue-500 rounded-full opacity-10 pointer-events-none"></div>

    <div class="max-w-6xl mx-auto px-6 w-full grid grid-cols-1 md:grid-cols-2 gap-8 items-center py-12">
        <div class="space-y-6 z-10">
            <span class="text-blue-300 uppercase tracking-widest text-xs font-bold bg-blue-500/20 px-3 py-1 rounded-full">Soluciones para PyMEs</span>
            <h1 class="text-4xl md:text-5xl font-black tracking-tight leading-tight">
                El impulso financiero <br>que tu negocio necesita.
            </h1>
            <p class="text-base text-blue-100/90">
                Abre tu Cuenta Corriente Comercial sin mantenimiento el primer año, accede a capital de trabajo inmediato y digitaliza tus cobros de manera simple.
            </p>
            
            <ul class="space-y-3 text-sm text-blue-200">
                <li class="flex items-center space-x-3">
                    <i class="fa-solid fa-store text-blue-400"></i>
                    <span>Línea de crédito comercial adaptada al flujo de tu empresa.</span>
                </li>
                <li class="flex items-center space-x-3">
                    <i class="fa-solid fa-laptop-invoice text-blue-400"></i>
                    <span>Pasarela de pagos web y POS con tasas preferenciales.</span>
                </li>
            </ul>

            <div class="pt-2">
                <a href="#" class="bg-blue-600 hover:bg-blue-700 text-white font-bold px-8 py-3.5 rounded-lg text-sm shadow-xl transition inline-block">
                    Solicitar Cuenta Comercial
                </a>
            </div>
        </div>

        <div class="flex justify-center md:justify-end z-10">
            <div class="bg-slate-900/90 backdrop-blur-md border border-blue-500/30 p-6 rounded-2xl w-full max-w-sm shadow-2xl text-white">
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <p class="text-[10px] uppercase text-zinc-400 tracking-wider">Ventas Digitales este Mes</p>
                        <h4 class="text-xl font-bold text-emerald-400">S/ 24,500.00</h4>
                    </div>
                    <span class="bg-emerald-500/20 text-emerald-400 text-xs px-2 py-1 rounded font-bold">+15%</span>
                </div>
                <div class="flex items-end justify-between h-24 pt-4 border-t border-zinc-800">
                    <div class="w-8 bg-blue-500 rounded-t h-12"></div>
                    <div class="w-8 bg-blue-400 rounded-t h-16"></div>
                    <div class="w-8 bg-indigo-500 rounded-t h-20"></div>
                    <div class="w-8 bg-blue-600 rounded-t h-24"></div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="max-w-6xl mx-auto px-6 py-16">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm hover:shadow-md transition">
            <i class="fa-solid fa-money-bill-trend-up text-blue-600 text-2xl mb-4 block"></i>
            <h3 class="font-bold text-gray-900 text-lg mb-2">Capital de Trabajo</h3>
            <p class="text-gray-500 text-sm">Financiación a corto plazo para compra de mercadería, pago a proveedores o campañas comerciales.</p>
        </div>
        <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm hover:shadow-md transition">
            <i class="fa-solid fa-building-columns text-blue-600 text-2xl mb-4 block"></i>
            <h3 class="font-bold text-gray-900 text-lg mb-2">Préstamos Activo Fijo</h3>
            <p class="text-gray-500 text-sm">Financia la adquisición de locales comerciales, maquinaria pesada o renovación de flota vehicular.</p>
        </div>
        <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm hover:shadow-md transition">
            <i class="fa-solid fa-money-check-dollar text-blue-600 text-2xl mb-4 block"></i>
            <h3 class="font-bold text-gray-900 text-lg mb-2">Factoring Electrónico</h3>
            <p class="text-gray-500 text-sm">Consigue liquidez inmediata cobrando tus facturas por adelantado de manera 100% online.</p>
        </div>
    </div>
</section>
@endsection