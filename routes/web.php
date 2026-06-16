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

// 2. LOGIN
Route::get('/login', function () {
    if (Session::has('usuario_logeado')) return redirect('/dashboard');
    return view('login');
})->name('login'); 

Route::post('/login', [AuthController::class, 'procesarLogin']);

// 3. REGISTRO
Route::get('/register', function () {
    return view('register');
})->name('register'); 

Route::post('/register', [AuthController::class, 'procesarRegistro']);

// 4. PANEL PRIVADO Y CIERRE DE SESIÓN
Route::get('/dashboard', function () {
    if (!Session::has('usuario_logeado')) return redirect('/login');
    return view('dashboard');
});

Route::get('/logout', [AuthController::class, 'cerrarSesion']);