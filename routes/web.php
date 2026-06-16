<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\AuthController;

// 1. INICIO: página de bienvenida con el menú interactivo
Route::get('/', function () {
    return view('paginas.personas');
});

// 1.2. Singular
Route::get('/singular', function () {
    return view('paginas.singular');
});

// 1.3. Wealth
Route::get('/wealth', function () {
    return view('paginas.wealth');
});

// 1.4. Negocios
Route::get('/negocios', function () {
    return view('paginas.negocios');
});

// 1.5. Grandes empresas
Route::get('/grandes-empresas', function () {
    return view('paginas.corporativo');
});

// 1.6. Quiénes somos
Route::get('/quienes-somos', function () {
    return view('paginas.nosotros');
});

// 2. SUBMENU
// 2.1. Canales
Route::get('/canales', function () {
    return view('paginas.submenu.canales');
});

// 2.2. Ahorros
Route::get('/ahorros', function () {
    return view('paginas.submenu.ahorros');
});

// 2.3. Tarjetas
Route::get('/tarjetas', function () {
    return view('paginas.submenu.tarjetas');
});

// 2.4. Préstamos
Route::get('/prestamos', function () {
    return view('paginas.submenu.prestamos');
});

// 2.5. Depósitos e Inversión
Route::get('/depositos-inversion', function () {
    return view('paginas.submenu.depositos');
});

// 2.6. Seguros
Route::get('/seguros', function () {
    return view('paginas.submenu.seguros');
});

// 2.7. Programas de Lealtad
Route::get('/programas-lealtad', function () {
    return view('paginas.submenu.lealtad');
});

// 3. LOGIN
Route::get('/login', function () {
    if (Session::has('usuario_logeado')) return redirect('/dashboard');
    return view('login');
})->name('login'); 

Route::post('/login', [AuthController::class, 'procesarLogin']);

// 4. REGISTRO
Route::get('/register', function () {
    return view('register');
})->name('register'); 

Route::post('/register', [AuthController::class, 'procesarRegistro']);

// 5. PANEL PRIVADO Y CIERRE DE SESIÓN
Route::get('/dashboard', function () {
    if (!Session::has('usuario_logeado')) return redirect('/login');
    return view('dashboard');
});

Route::get('/logout', [AuthController::class, 'cerrarSesion']);