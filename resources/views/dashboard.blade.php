<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mi Banco - Scotiabank</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans">
    <nav class="bg-white shadow-sm border-b-4 border-[#EC111A] p-4 flex justify-between items-center px-8">
        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/1/1a/Scotiabank_Logo.svg/512px-Scotiabank_Logo.svg.png" class="h-6">
        <div class="flex items-center space-x-4">
            <span class="text-sm font-semibold text-gray-600">Hola, {{ Session::get('usuario_nombre') }}</span>
            <a href="/logout" class="text-sm text-[#0082c3] hover:underline font-semibold">Cerrar Sesión</a>
        </div>
    </nav>

    <div class="max-w-5xl mx-auto mt-10 p-4">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Resumen de Productos</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-white p-6 rounded-lg shadow-sm border-t-4 border-[#EC111A]">
                <p class="text-gray-500 text-sm font-semibold mb-2">Cuenta Free - Soles</p>
                <h3 class="text-3xl font-bold text-gray-800">S/ 4,500.00</h3>
            </div>
            <div class="bg-white p-6 rounded-lg shadow-sm border-t-4 border-gray-800">
                <p class="text-gray-500 text-sm font-semibold mb-2">Préstamo Personal</p>
                <h3 class="text-3xl font-bold text-gray-800">S/ 12,000.00</h3>
            </div>
        </div>
    </div>
</body>
</html>