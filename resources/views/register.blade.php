<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Scotiabank - Registro</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#F4F4F4] flex items-center justify-center h-screen">
    <div class="bg-white p-10 rounded-xl shadow-xl w-[400px]">
        <img src="https://www.scotiabank.com.pe/SVP/CapitalHumano/img/logo_scotiabank.png" class="h-8 mb-6">
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