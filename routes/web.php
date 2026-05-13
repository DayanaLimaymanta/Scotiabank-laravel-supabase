<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\AuthController;

Route::get('/login', function () {
    if (Session::has('usuario_logeado')) return redirect('/dashboard');
    return view('login');
});

Route::post('/login', [AuthController::class, 'procesarLogin']);

Route::get('/dashboard', function () {
    if (!Session::has('usuario_logeado')) return redirect('/login');
    return view('dashboard');
});

Route::get('/logout', [AuthController::class, 'cerrarSesion']);

Route::get('/', function () {
    return redirect('/login');
});