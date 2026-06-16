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
                
            <!-- CONTENEDOR DEL MENÚ DESPLEGABLE ACCEDER (CORREGIDO) -->
            <div class="relative">
                <button id="layout-btn-acceder" class="bg-red-600 hover:bg-red-700 text-white font-medium text-sm px-5 py-2.5 rounded-lg flex items-center space-x-2 shadow-md transition focus:outline-none cursor-pointer">
                    <span>Acceder</span>
                    <i id="layout-icon-chevron" class="fa-solid fa-chevron-down text-xs transition-transform duration-200"></i>
                </button>

                <!-- Dropdown Flotante Interactivo -->
                <div id="layout-dropdown-acceder" class="hidden absolute right-0 top-full mt-2 w-48 bg-red-600 text-white rounded-lg shadow-2xl overflow-hidden z-[100] border border-red-500/30">
                    <a href="{{ route('login') }}" class="block px-4 py-3 text-sm font-semibold border-b border-red-500/40 hover:bg-red-700 transition">
                        Personas
                    </a>
                    <a href="{{ route('login') }}" class="block px-4 py-3 text-sm font-semibold border-b border-red-500/40 hover:bg-red-700 transition">
                        Negocios
                    </a>
                    <a href="{{ route('login') }}" class="block px-4 py-3 text-sm font-semibold hover:bg-red-700 transition">
                        Telebanking
                    </a>
                </div>
            </div>
                
                <a href="{{ route('register') }}" class="border border-red-600 text-red-600 hover:bg-red-50 font-medium text-sm px-4 py-2.5 rounded-lg transition hidden sm:inline-block">
                    Abrir Cuenta Digital
                </a>
            </div>
        </div>

        <!-- SUB-MENÚ DE PRODUCTOS MIGRADO AL LAYOUT MAESTRO -->
        <div id="sub-menu" class="border-t border-gray-100 bg-white px-6 py-3 hidden md:flex space-x-8 text-xs font-medium text-gray-600 justify-start transition-all duration-300">
            <a href="/canales" class="hover:text-red-600 transition @yield('active-canales') border-b border-transparent pb-1">Canales</a>
            <a href="/ahorros" class="hover:text-red-600 transition @yield('active-ahorros') border-b border-transparent pb-1">Ahorros</a>
            <a href="/tarjetas" class="hover:text-red-600 transition @yield('active-tarjetas') border-b border-transparent pb-1">Tarjetas</a>
            <a href="/prestamos" class="hover:text-red-600 transition @yield('active-prestamos') border-b border-transparent pb-1">Préstamos</a>
            <a href="/depositos-inversion" class="hover:text-red-600 transition @yield('active-depositos') border-b border-transparent pb-1">Depósitos e Inversión</a>
            <a href="/seguros" class="hover:text-red-600 transition @yield('active-seguros') border-b border-transparent pb-1">Seguros</a>
            <a href="/programas-lealtad" class="hover:text-red-600 transition @yield('active-lealtad') border-b border-transparent pb-1">Programas de Lealtad</a>
        </div>
    </header>

    <main>
        @yield('contenido')
    </main>

    <script>
        // Elementos para el Scroll
        const header = document.getElementById('main-header');
        const topBar = document.getElementById('top-bar');
        const midBar = document.getElementById('mid-bar');
        const subMenu = document.getElementById('sub-menu');

        window.addEventListener('scroll', function() {
            if (window.scrollY > 50) {
                topBar.classList.add('hidden');
                subMenu.classList.add('hidden');
                midBar.classList.add('py-2');
                header.classList.add('shadow-md');
                document.body.style.paddingTop = '70px';
            } else {
                topBar.classList.remove('hidden');
                subMenu.classList.remove('hidden');
                midBar.classList.remove('py-2');
                header.classList.remove('shadow-md');
                if (window.innerWidth >= 768) {
                    document.body.style.paddingTop = '130px';
                } else {
                    document.body.style.paddingTop = '140px';
                }
            }
        });

        // Elementos para el Menú Desplegable "Acceder"
        const btnAcceder = document.getElementById('layout-btn-acceder');
        const dropdownAcceder = document.getElementById('layout-dropdown-acceder');
        const iconChevron = document.getElementById('layout-icon-chevron');

        if (btnAcceder && dropdownAcceder) {
            btnAcceder.addEventListener('click', (e) => {
                e.stopPropagation(); // Evita que el clic se propague al documento
                dropdownAcceder.classList.toggle('hidden');
                if (iconChevron) {
                    iconChevron.classList.toggle('rotate-180');
                }
            });

            // Cerrar el menú si se hace clic en cualquier otra parte de la pantalla
            document.addEventListener('click', (e) => {
                if (!btnAcceder.contains(e.target)) {
                    dropdownAcceder.classList.add('hidden');
                    if (iconChevron) {
                        iconChevron.classList.remove('rotate-180');
                    }
                }
            });
        }
    </script>
</body>
</html>