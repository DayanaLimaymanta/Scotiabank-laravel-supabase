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

        <h2 class="text-2xl font-bold mb-4 text-[#EC111A]">Crear Cuenta</h2>
        <form method="POST" action="/register" class="space-y-4">
            @csrf
            <div>
                <label class="text-xs font-bold text-gray-400">DNI</label>
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