<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scotiabank Perú | @yield('titulo', 'Personas')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;900&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .transition-all { transition: all 0.3s ease; }
    </style>
</head>
<body class="bg-white text-gray-800 pt-[140px] md:pt-[130px]">

    <header id="main-header" class="fixed top-0 left-0 w-full z-50 bg-white transition-all duration-300">
        
        <div id="top-bar" class="border-b border-gray-100 px-6 py-2 flex justify-between items-center text-xs text-gray-500 transition-all duration-300">
            <div class="flex space-x-6 font-medium">
                <a href="/" class="hover:text-red-600 transition @yield('active-personas') border-b-2 border-transparent pb-1">Personas</a>
                <a href="/singular" class="hover:text-red-600 transition @yield('active-singular') border-b-2 border-transparent pb-1">Singular</a>
                <a href="/wealth" class="hover:text-red-600 transition @yield('active-wealth') border-b-2 border-transparent pb-1">Wealth</a>
                <a href="/negocios" class="hover:text-red-600 transition @yield('active-negocios') border-b-2 border-transparent pb-1">Negocios</a>
                <a href="/grandes-empresas" class="hover:text-red-600 transition @yield('active-corporativo') border-b-2 border-transparent pb-1 hidden sm:inline">Grandes Empresas</a>
                <a href="/quienes-somos" class="hover:text-red-600 transition @yield('active-nosotros') border-b-2 border-transparent pb-1 hidden md:inline">Quiénes Somos</a>
            </div>
            <div class="font-medium hover:text-gray-800 cursor-pointer">
                More Sites <i class="fa-solid fa-chevron-down text-[10px] ml-1"></i>
            </div>
        </div>

        <div id="mid-bar" class="px-6 py-4 flex justify-between items-center border-b border-gray-100 transition-all duration-300">
            <div class="flex items-center space-x-8">
                @yield('logo-banco')
                
                <div class="hidden md:flex items-center bg-gray-50 border border-gray-200 rounded-lg px-3 py-1.5 w-64 lg:w-80 focus-within:border-gray-400 transition">
                    <input type="text" placeholder="Búsqueda" class="bg-transparent outline-none text-sm w-full text-gray-600 placeholder-gray-400">
                    <i class="fa-solid fa-magnifying-glass text-gray-400 text-sm cursor-pointer hover:text-gray-600"></i>
                </div>
            </div>

            <div class="flex items-center space-x-4">
                <div class="hidden lg:flex flex-col items-center text-center cursor-pointer text-gray-600 hover:text-red-600 transition">
                    <i class="fa-regular fa-user text-xl"></i>
                    <span class="text-[10px] font-medium mt-1">Hazte Cliente</span>
                </div>
                
                <a href="{{ route('login') }}" class="bg-red-600 hover:bg-red-700 text-white font-medium text-sm px-5 py-2.5 rounded-lg flex items-center space-x-2 shadow-md transition">
                    <span>Acceder</span>
                    <i class="fa-solid fa-chevron-down text-xs"></i>
                </a>
                
                <a href="{{ route('register') }}" class="border border-red-600 text-red-600 hover:bg-red-50 font-medium text-sm px-4 py-2.5 rounded-lg transition hidden sm:inline-block">
                    Abrir Cuenta Digital
                </a>
            </div>
        </div>

        <div id="sub-menu" class="border-t border-gray-100 bg-white px-6 py-3 hidden md:flex space-x-8 text-xs font-medium text-gray-600 justify-start transition-all duration-300">
            <a href="#" class="hover:text-red-600 transition">Canales</a>
            <a href="#" class="hover:text-red-600 transition">Ahorros</a>
            <a href="#" class="hover:text-red-600 transition">Tarjetas</a>
            <a href="#" class="hover:text-red-600 transition">Préstamos</a>
            <a href="#" class="hover:text-red-600 transition">Depósitos e Inversión</a>
            <a href="#" class="hover:text-red-600 transition">Seguros</a>
            <a href="#" class="hover:text-red-600 transition">Programas de Lealtad</a>
        </div>
    </header>

    <main>
        @yield('contenido')
    </main>

    <script>
        window.addEventListener('scroll', function() {
            const header = document.getElementById('main-header');
            const topBar = document.getElementById('top-bar');
            const midBar = document.getElementById('mid-bar');
            const subMenu = document.getElementById('sub-menu');

            if (window.scrollY > 50) {
                // Colapsar y encoger el menú cuando se hace scroll hacia abajo
                topBar.classList.add('hidden');
                subMenu.classList.add('hidden');
                midBar.classList.add('py-2');
                header.classList.add('shadow-md');
                document.body.style.paddingTop = '70px';
            } else {
                // Volver al tamaño original arriba de todo
                topBar.classList.remove('hidden');
                subMenu.classList.remove('hidden');
                midBar.classList.remove('py-2');
                header.classList.remove('shadow-md');
                // Restaurar el espacio correcto según la pantalla
                if (window.innerWidth >= 768) {
                    document.body.style.paddingTop = '130px';
                } else {
                    document.body.style.paddingTop = '140px';
                }
            }
        });
    </script>
</body>
</html>