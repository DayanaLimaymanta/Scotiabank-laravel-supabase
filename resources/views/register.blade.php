<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Scotiabank - Registro</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#F4F4F4] flex items-center justify-center h-screen">
    <div class="bg-white p-10 rounded-xl shadow-xl w-[400px]">
        <div class="text-red-600 font-extrabold text-3xl tracking-tight flex items-center">
            <span class="bg-red-600 text-white rounded-full w-8 h-8 flex items-center justify-center text-xl mr-2 font-serif">S</span>
            Scotiabank<span class="text-red-600 text-xs align-top mt-1">®</span>
        </div>

        <h2 class="text-2xl font-bold mb-1 text-[#EC111A]">Crear Cuenta</h2>
        <p class="text-xs text-gray-500 mb-4">
            Este registro es solo para <strong>clientes</strong> (banca por internet).
            Si eres asesor o personal del banco, no necesitas registrarte: inicia sesión
            en el <a href="/login?rol=asesor" class="text-[#0082c3] font-bold hover:underline">Portal Asesores</a>
            usando tu número de DNI como usuario y contraseña.
        </p>
        @if(Session::has('error'))
            <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 mb-4 text-xs font-semibold rounded">
                {{ Session::get('error') }}
            </div>
        @endif

        <form method="POST" action="/register" class="space-y-4">
            @csrf
            <div>
                <label class="text-xs font-bold text-gray-400 block mb-1">TIPO DE DOCUMENTO</label>
                <select name="tipo_doc" class="w-full border-b-2 outline-none focus:border-[#EC111A] bg-transparent py-1">
                    <option value="DNI">DNI</option>
                    <option value="CE">Carné de Extranjería</option>
                    <option value="RUC">RUC</option>
                    <option value="PAS">Pasaporte</option>
                    <option value="PTP">Permiso Temporal de Permanencia</option>
                    <option value="FFPP">Carné FF.PP.</option>
                    <option value="FFAA">Carné FF.AA.</option>
                </select>
            </div>
            <div>
                <label class="text-xs font-bold text-gray-400">NÚMERO DE DOCUMENTO</label>
                <input type="text" name="documento" required class="w-full border-b-2 outline-none focus:border-[#EC111A]">
            </div>
            <div>
                <label class="text-xs font-bold text-gray-400">NOMBRE</label>
                <input type="text" name="nombre" required class="w-full border-b-2 outline-none focus:border-[#EC111A]">
            </div>
            <div>
                <label class="text-xs font-bold text-gray-400">CONTRASEÑA</label>
                <input type="password" name="password" required class="w-full border-b-2 outline-none focus:border-[#EC111A]">
            </div>
            <button type="submit" class="w-full bg-[#EC111A] text-white py-3 rounded font-bold uppercase">Registrarme</button>
        </form>
    </div>
</body>
</html>