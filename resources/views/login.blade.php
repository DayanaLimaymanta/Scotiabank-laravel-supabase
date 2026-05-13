<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Scotiabank - Iniciar Sesión</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="h-screen w-full flex font-sans text-gray-800 bg-slate-50">

    <div class="w-full md:w-1/3 bg-white p-8 md:p-12 flex flex-col justify-center shadow-lg z-10">
        <div class="text-red-600 text-4xl font-bold mb-8">
            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/1/1a/Scotiabank_Logo.svg/512px-Scotiabank_Logo.svg.png" alt="Scotiabank" class="h-8">
        </div>

        <h1 class="text-2xl font-bold mb-6">Inicia sesión</h1>

        @if(Session::has('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4 text-sm">
                {{ Session::get('error') }}
            </div>
        @endif

        <form method="POST" action="/login" class="flex flex-col space-y-6">
            @csrf 
            <div class="flex flex-col">
                <label class="text-sm font-semibold mb-1">Tipo de documento</label>
                <select class="border-b border-gray-400 py-2 outline-none focus:border-red-600 bg-transparent">
                    <option>DNI</option>
                    <option>CE</option>
                </select>
            </div>
            <div class="flex flex-col">
                <label class="text-sm font-semibold mb-1">Número de documento</label>
                <input type="text" name="documento" required placeholder="Ingresar dato" class="border-b border-gray-400 py-2 outline-none focus:border-red-600">
            </div>
            <div class="flex flex-col">
                <label class="text-sm font-semibold mb-1">Contraseña</label>
                <input type="password" name="password" required placeholder="Ingresa tu contraseña" class="border-b border-gray-400 py-2 outline-none focus:border-red-600">
            </div>
            <button type="submit" class="w-full bg-[#EC111A] text-white font-semibold py-3 rounded mt-4 hover:bg-red-700 transition">
                Ingresar
            </button>
        </form>
    </div>

    <div class="hidden md:flex w-2/3 items-center justify-center relative">
        <div class="max-w-xl">
            <h2 class="text-4xl font-bold text-gray-900 mb-8">Abre ahora tu nueva<br>Cuenta Digital</h2>
            <ul class="space-y-6">
                <li class="flex items-center space-x-4"><span class="text-green-500 text-2xl">💰</span><span class="text-gray-700">Sin costo de mantenimiento.</span></li>
                <li class="flex items-center space-x-4"><span class="text-purple-500 text-2xl">📱</span><span class="text-gray-700">Transferencias digitales gratis.</span></li>
            </ul>
        </div>
    </div>
</body>
</html>