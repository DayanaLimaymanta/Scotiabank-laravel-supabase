<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SolicitudController;

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
    $rolSolicitado = request()->query('rol', 'cliente');
    if (Session::has('usuario_logeado') && Session::get('usuario_rol') === $rolSolicitado) {
        return redirect('/dashboard');
    }
    return view('login');
})->name('login'); 

Route::post('/login', [AuthController::class, 'procesarLogin']);

// 4. REGISTRO
Route::get('/register', function () {
    return view('register');
})->name('register'); 

Route::post('/register', [AuthController::class, 'procesarRegistro']);

// 5. PANEL PRIVADO Y CIERRE DE SESIÓN
Route::get('/dashboard', [SolicitudController::class, 'mostrarDashboard']);

Route::get('/logout', [AuthController::class, 'cerrarSesion']);

// 6. SOLICITUDES DE CRÉDITO
Route::get('/solicitar-prestamo', [SolicitudController::class, 'mostrarFormulario']);
Route::post('/solicitar-prestamo', [SolicitudController::class, 'guardarSolicitud']);

// Acciones operativas del día a día: el asesor de negocios busca
// clientes, registra solicitudes, las desembolsa una vez aprobadas,
// ve la evaluación crediticia y registra gestiones de cobranza (R2).
// No aprueba montos ni decide acciones críticas de mora.
Route::middleware('rol:asesor')->prefix('asesor')->group(function () {
    Route::get('/buscar-cliente',       [SolicitudController::class, 'buscarCliente']);
    Route::post('/registrar-solicitud', [SolicitudController::class, 'registrarSolicitud']);
    Route::post('/desembolsar-solicitud', [SolicitudController::class, 'desembolsarSolicitud']);
    Route::get('/evaluar-cliente',      [SolicitudController::class, 'evaluarCliente']);
    Route::post('/registrar-gestion',   [SolicitudController::class, 'registrarGestion']);
});

// Aprobación de solicitudes: decisión final del crédito, atribución
// de quien firma por la agencia (administrador) o por encima de ella
// (gerencia). El asesor de negocios NO puede autoaprobar su propia
// propuesta -- separación de funciones.
Route::middleware('rol:administrador,gerencia')->prefix('asesor')->group(function () {
    Route::post('/aprobar-solicitud', [SolicitudController::class, 'aprobarSolicitud']);
});

// Acciones críticas de cobranza (R3): derivar a judicial y castigar
// son decisiones de riesgo de cartera -- atribución exclusiva del
// área de Riesgos (más gerencia, que tiene autoridad sobre toda
// decisión crítica del banco).
Route::middleware('rol:riesgos,gerencia')->prefix('asesor')->group(function () {
    Route::post('/derivar-judicial', [SolicitudController::class, 'derivarJudicial']);
    Route::post('/castigar-credito', [SolicitudController::class, 'castigarCredito']);
});