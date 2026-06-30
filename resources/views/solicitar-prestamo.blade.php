<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solicitar Préstamo Efectivo - Scotiabank</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;900&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-[#f4f6f9] text-gray-800 min-h-screen flex flex-col">

    <!-- Navbar -->
    <nav class="bg-white shadow-sm border-b-4 border-[#EC111A] sticky top-0 z-50">
        <div class="max-w-4xl mx-auto px-6 h-16 flex justify-between items-center">
            <div class="text-red-600 font-extrabold text-3xl tracking-tight flex items-center">
                <span class="bg-red-600 text-white rounded-full w-8 h-8 flex items-center justify-center text-xl mr-2 font-serif">S</span>
                Scotiabank<span class="text-red-600 text-xs align-top mt-1">®</span>
            </div>
            
            <div class="flex items-center space-x-4">
                <div class="flex items-center space-x-2 bg-gray-50 px-3 py-1.5 rounded-lg border border-gray-100">
                    <div class="w-7 h-7 bg-[#EC111A]/10 text-[#EC111A] rounded-full flex items-center justify-center font-bold text-xs uppercase">
                        {{ substr($cliente->nomcliente ?? 'U', 0, 2) }}
                    </div>
                    <span class="text-xs font-semibold text-gray-700">Hola, {{ explode(' ', $cliente->nomcliente)[0] ?? 'Cliente' }}</span>
                </div>
                <a href="/logout" class="text-xs text-gray-500 hover:text-[#EC111A] font-medium flex items-center space-x-1 transition">
                    <i class="fa-solid fa-power-off"></i>
                    <span class="hidden sm:inline">Cerrar Sesión</span>
                </a>
            </div>
        </div>
    </nav>

    <!-- Main Container -->
    <main class="flex-1 max-w-lg mx-auto w-full px-6 py-10">
        
        <!-- Back Button -->
        <a href="/dashboard" class="inline-flex items-center text-xs font-bold text-gray-500 hover:text-[#EC111A] mb-6 transition">
            <i class="fa-solid fa-arrow-left mr-2"></i>
            Regresar a Inicio
        </a>

        <!-- Header Title -->
        <div class="mb-8">
            <h1 class="text-2xl font-black text-gray-900 tracking-tight flex items-center">
                <i class="fa-solid fa-hand-holding-dollar mr-3 text-[#EC111A]"></i>
                Solicitar Préstamo Efectivo
            </h1>
            <p class="text-xs text-gray-500 mt-1.5 leading-relaxed">
                Completa los datos de tu solicitud. La información será procesada y asignada a un asesor del banco para su respectiva aprobación.
            </p>
        </div>

        <!-- Alert messages -->
        @if(Session::has('error'))
            <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded shadow-sm text-xs font-medium">
                {{ Session::get('error') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded shadow-sm text-xs font-medium space-y-1">
                @foreach ($errors->all() as $error)
                    <div><i class="fa-solid fa-circle-exclamation mr-1"></i> {{ $error }}</div>
                @endforeach
            </div>
        @endif

        <!-- Card Form -->
        <div class="bg-white border border-gray-200/80 rounded-2xl shadow-xl overflow-hidden p-6 space-y-6">
            
            <!-- Customer Information Summary -->
            <div class="bg-gray-50 border border-gray-100 rounded-xl p-4 flex items-center space-x-4">
                <div class="bg-red-50 text-[#EC111A] p-2.5 rounded-full text-base">
                    <i class="fa-regular fa-user"></i>
                </div>
                <div class="text-xs">
                    <p class="font-bold text-gray-700 mb-0.5">{{ $cliente->nomcliente }}</p>
                    <p class="text-gray-400 font-mono">{{ $cliente->destipodocumentoidentidad }}: {{ $cliente->numerodocumentoidentidad }}</p>
                </div>
            </div>

            <!-- Form -->
            <form method="POST" action="/solicitar-prestamo" class="space-y-5">
                @csrf

                <!-- Currency -->
                <div class="flex flex-col border-b border-gray-200 focus-within:border-[#EC111A] transition-all pb-1.5">
                    <label class="text-[9px] uppercase font-bold text-gray-400 tracking-wider">Moneda</label>
                    <select name="moneda" disabled class="w-full bg-transparent py-1 outline-none text-gray-700 font-medium cursor-not-allowed">
                        <option value="1">Soles (S/)</option>
                    </select>
                </div>

                <!-- Product -->
                <div class="flex flex-col border-b border-gray-200 focus-within:border-[#EC111A] transition-all pb-1.5">
                    <label class="text-[9px] uppercase font-bold text-gray-400 tracking-wider">Producto de Crédito</label>
                    <select name="producto" disabled class="w-full bg-transparent py-1 outline-none text-gray-700 font-medium cursor-not-allowed">
                        <option value="8">Crédito Consumo</option>
                    </select>
                </div>

                <!-- Monto Solicitado -->
                <div class="flex flex-col border-b border-gray-200 focus-within:border-[#EC111A] transition-all pb-1.5">
                    <label class="text-[9px] uppercase font-bold text-gray-400 tracking-wider">Monto Solicitado (S/)</label>
                    <div class="flex items-center">
                        <span class="text-gray-400 font-bold mr-1.5 text-sm">S/</span>
                        <input type="number" name="monto" value="{{ old('monto') }}" step="0.01" min="100" max="100000" required placeholder="Ej. 5000.00" 
                               class="w-full bg-transparent py-1 outline-none text-gray-700 font-semibold text-lg placeholder-gray-300">
                    </div>
                </div>

                <!-- Plazo (cuotas) -->
                <div class="flex flex-col border-b border-gray-200 focus-within:border-[#EC111A] transition-all pb-1.5">
                    <label class="text-[9px] uppercase font-bold text-gray-400 tracking-wider">Plazo de Pago (Meses)</label>
                    <select name="cuotas" class="w-full bg-transparent py-1 outline-none text-gray-700 font-medium cursor-pointer">
                        @for($i = 6; $i <= 36; $i += 6)
                            <option value="{{ $i }}" {{ old('cuotas') == $i ? 'selected' : '' }}>{{ $i }} Meses</option>
                        @endfor
                        <option value="48" {{ old('cuotas') == 48 ? 'selected' : '' }}>48 Meses</option>
                        <option value="60" {{ old('cuotas') == 60 ? 'selected' : '' }}>60 Meses</option>
                        <option value="72" {{ old('cuotas') == 72 ? 'selected' : '' }}>72 Meses</option>
                    </select>
                </div>

                <!-- Terms and Simulator Notice -->
                <div class="bg-blue-50 border border-blue-100 rounded-xl p-3 flex space-x-3 text-[11px] text-blue-800 leading-normal">
                    <i class="fa-solid fa-circle-info mt-0.5 text-blue-600"></i>
                    <p>
                        Esta solicitud pasará por una evaluación preliminar de tu historial crediticio. Se te aplicará una tasa compensatoria anual de acuerdo a tu perfil de riesgo.
                    </p>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="w-full bg-[#EC111A] hover:bg-red-700 text-white font-bold py-3.5 rounded-xl shadow-md hover:shadow-lg transition-all uppercase tracking-widest text-xs mt-4">
                    Enviar Pre-Solicitud
                </button>
            </form>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-100 border-t border-gray-200 py-6 text-center text-[10px] text-gray-400">
        <p>© 2026 Scotiabank Perú S.A.A. Todos los derechos reservados.</p>
    </footer>

</body>
</html>
