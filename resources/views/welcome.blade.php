<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scotiabank Perú | Personas</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .sticky-transition {
            transition: all 0.3s ease-in-out;
        }
    </style>
</head>
<body class="bg-gray-50 text-gray-800 antialiased font-sans">

    <header id="main-header" class="fixed top-0 left-0 w-full z-50 bg-white shadow-sm sticky-transition">
        
        <div id="top-bar" class="border-b border-gray-100 text-xs text-gray-600 px-6 py-2 flex justify-between items-center bg-white sticky-transition">
            <div class="flex space-x-6">
                <a href="#" class="font-bold border-b-2 border-red-600 pb-2 text-gray-900">Personas</a>
                <a href="#" class="hover:text-red-600 transition">Singular</a>
                <a href="#" class="hover:text-red-600 transition">Wealth</a>
                <a href="#" class="hover:text-red-600 transition">Negocios</a>
                <a href="#" class="hover:text-red-600 transition">Grandes Empresas</a>
                <a href="#" class="hover:text-red-600 transition">Quiénes Somos</a>
            </div>
            <div class="text-gray-500 hover:text-gray-800 cursor-pointer">
                More Sites <i class="fa-solid fa-chevron-down text-[10px] ml-1"></i>
            </div>
        </div>

        <div id="nav-body" class="px-6 py-4 flex justify-between items-center bg-white sticky-transition">
            <div class="flex items-center space-x-8">
                <div class="text-red-600 font-extrabold text-3xl tracking-tight flex items-center">
                    <span class="bg-red-600 text-white rounded-full w-8 h-8 flex items-center justify-center text-xl mr-2 font-serif">S</span>
                    Scotiabank<span class="text-red-600 text-xs align-top mt-1">®</span>
                </div>
                
                <div class="relative w-80 hidden md:block">
                    <input type="text" placeholder="Búsqueda" class="w-full bg-gray-50 border border-gray-200 rounded-lg pl-4 pr-10 py-2 text-sm focus:outline-none focus:border-red-500 transition">
                    <i class="fa-solid fa-magnifying-glass absolute right-3 top-3 text-gray-400 text-sm"></i>
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
                
                <a href="{{ route('register') }}" class="border border-red-600 text-red-600 hover:bg-red-50 font-medium text-sm px-4 py-2.5 rounded-lg transition">
                    Abrir Cuenta Digital
                </a>
            </div>
        </div>

        <div id="sub-menu" class="border-t border-gray-100 bg-white px-6 py-3 hidden md:flex space-x-8 text-xs font-medium text-gray-600 justify-start">
            <a href="#" class="hover:text-red-600 transition">Canales</a>
            <a href="#" class="hover:text-red-600 transition">Ahorros</a>
            <a href="#" class="hover:text-red-600 transition">Tarjetas</a>
            <a href="#" class="hover:text-red-600 transition">Préstamos</a>
            <a href="#" class="hover:text-red-600 transition">Depósitos e Inversión</a>
            <a href="#" class="hover:text-red-600 transition">Seguros</a>
            <a href="#" class="hover:text-red-600 transition">Programas de Lealtad</a>
        </div>
    </header>


    <main class="pt-[160px]"> <section class="relative bg-gradient-to-r from-red-700 to-red-600 text-white min-h-[420px] flex items-center overflow-hidden">
            <div class="absolute -right-16 -bottom-16 w-96 h-96 bg-red-500 rounded-full opacity-20 pointer-events-none"></div>
            <div class="absolute right-1/4 top-10 w-64 h-64 bg-red-400 rounded-full opacity-10 pointer-events-none"></div>

            <div class="max-w-6xl mx-auto px-6 w-full grid grid-cols-1 md:grid-cols-2 gap-8 items-center py-12">
                <div class="space-y-6 z-10">
                    <h1 class="text-4xl md:text-5xl font-black tracking-tight leading-tight">
                        ¡Gana S/50 SIN sorteos!
                    </h1>
                    <p class="text-lg text-red-100">
                        Abre tu primera Cuenta Digital y empieza a disfrutar los beneficios exclusivos desde el primer día.
                    </p>
                    
                    <ul class="space-y-3 text-sm text-red-50">
                        <li class="flex items-center space-x-3">
                            <i class="fa-solid fa-arrow-right-arrow-left text-red-300"></i>
                            <span>Aprovecha un tipo de cambio preferencial.</span>
                        </li>
                        <li class="flex items-center space-x-3">
                            <i class="fa-solid fa-mobile-screen-button text-red-300"></i>
                            <span>Realiza transferencias digitales gratuitas.</span>
                        </li>
                    </ul>

                    <div class="flex space-x-4 pt-2">
                        <a href="#" class="bg-white text-red-600 hover:bg-gray-100 font-bold px-6 py-3 rounded-full text-sm shadow-lg transition">
                            Ábrela aquí
                        </a>
                        <a href="#" class="border border-white hover:bg-white/10 text-white font-semibold px-6 py-3 rounded-full text-sm transition">
                            Conoce más
                        </a>
                    </div>
                </div>

                <div class="flex justify-center md:justify-end z-10">
                    <div class="bg-white/10 backdrop-blur-md border border-white/20 p-6 rounded-2xl max-w-sm text-center shadow-2xl relative">
                        <div class="bg-red-600 text-white p-5 rounded-xl shadow-xl space-y-4">
                            <div class="bg-white p-3 rounded-lg inline-block mx-auto">
                                <i class="fa-solid fa-qrcode text-6xl text-gray-900"></i>
                            </div>
                            <h3 class="font-bold text-base">Hazte cliente Scotiabank aquí</h3>
                            <p class="text-xs text-red-100">Escanea el código QR desde tu celular y abre tu Cuenta Digital al instante.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="max-w-6xl mx-auto px-6 py-16">
            <div class="text-center max-w-xl mx-auto mb-12">
                <h2 class="text-2xl font-bold text-gray-900 mb-3">Nuestros productos más solicitados</h2>
                <p class="text-sm text-gray-500">Encuentra la solución financiera ideal que se adapte mejor a tus necesidades diarias.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm hover:shadow-md transition flex flex-col justify-between">
                    <div>
                        <div class="w-12 h-12 bg-red-50 text-red-600 rounded-lg flex items-center justify-center text-xl mb-4">
                            <i class="fa-solid fa-credit-card"></i>
                        </div>
                        <h3 class="font-bold text-gray-900 text-lg mb-2">Tarjetas de Crédito</h3>
                        <p class="text-gray-500 text-sm leading-relaxed mb-4">
                            Acumula puntos en cada compra, obtén devoluciones de efectivo y accede a miles de promociones.
                        </p>
                    </div>
                    <a href="#" class="text-red-600 font-semibold text-sm inline-flex items-center hover:underline">
                        Ver opciones <i class="fa-solid fa-arrow-right text-xs ml-2"></i>
                    </a>
                </div>

                <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm hover:shadow-md transition flex flex-col justify-between">
                    <div>
                        <div class="w-12 h-12 bg-red-50 text-red-600 rounded-lg flex items-center justify-center text-xl mb-4">
                            <i class="fa-solid fa-hand-holding-dollar"></i>
                        </div>
                        <h3 class="font-bold text-gray-900 text-lg mb-2">Préstamos Personales</h3>
                        <p class="text-gray-500 text-sm leading-relaxed mb-4">
                            Financiación inmediata con tasas preferenciales para hacer realidad tus proyectos personales.
                        </p>
                    </div>
                    <a href="#" class="text-red-600 font-semibold text-sm inline-flex items-center hover:underline">
                        Cotizar préstamo <i class="fa-solid fa-arrow-right text-xs ml-2"></i>
                    </a>
                </div>

                <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm hover:shadow-md transition flex flex-col justify-between">
                    <div>
                        <div class="w-12 h-12 bg-red-50 text-red-600 rounded-lg flex items-center justify-center text-xl mb-4">
                            <i class="fa-solid fa-shield-halved"></i>
                        </div>
                        <h3 class="font-bold text-gray-900 text-lg mb-2">Seguros Vehiculares y Vida</h3>
                        <p class="text-gray-500 text-sm leading-relaxed mb-4">
                            Protege lo que más quieres con pólizas flexibles, atención médica integral y soporte las 24 horas.
                        </p>
                    </div>
                    <a href="#" class="text-red-600 font-semibold text-sm inline-flex items-center hover:underline">
                        Conocer coberturas <i class="fa-solid fa-arrow-right text-xs ml-2"></i>
                    </a>
                </div>
            </div>
        </section>
    </main>

    <script>
        const header = document.getElementById('main-header');
        const topBar = document.getElementById('top-bar');
        const navBody = document.getElementById('nav-body');
        const subMenu = document.getElementById('sub-menu');

        window.addEventListener('scroll', () => {
            if (window.scrollY > 40) {
                // Al bajar: Escondemos sub-barras y achicamos paddings
                topBar.classList.add('hidden');
                subMenu.classList.add('hidden');
                navBody.classList.remove('py-4');
                navBody.classList.add('py-2', 'shadow-md');
            } else {
                // Al volver arriba: Restauramos el diseño original completo
                topBar.classList.remove('hidden');
                subMenu.classList.remove('hidden');
                navBody.classList.remove('py-2', 'shadow-md');
                navBody.classList.add('py-4');
            }
        });
    </script>
</body>
</html>