<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

/**
 * Middleware de control de acceso por rol.
 *
 * Uso en rutas:
 *   Route::post('/asesor/algo', [Controller::class, 'metodo'])
 *       ->middleware('rol:asesor');
 *
 *   Route::post('/admin/algo', [Controller::class, 'metodo'])
 *       ->middleware('rol:asesor,administrador'); // varios roles permitidos
 *
 * Si la sesión no existe -> redirige a /login.
 * Si el rol no coincide  -> 403 (JSON si es petición AJAX, vista si es navegación).
 */
class VerificarRol
{
    public function handle(Request $request, Closure $next, string ...$rolesPermitidos): Response
    {
        if (!Session::has('usuario_logeado')) {
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json(['success' => false, 'message' => 'No autenticado.'], 401);
            }
            return redirect('/login');
        }

        $rolActual = Session::get('usuario_rol');

        if (!in_array($rolActual, $rolesPermitidos, true)) {
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'No tienes permisos para realizar esta acción.',
                ], 403);
            }
            abort(403, 'No tienes permisos para acceder a esta sección.');
        }

        return $next($request);
    }
}