<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function procesarLogin(Request $request)
    {
        // Recibimos los datos del formulario
        $documento = $request->input('documento');
        $password = $request->input('password');

        // Buscamos al usuario en Supabase
        $usuario = DB::table('clientes')->where('documento', $documento)->first();

        // Validamos si existe y la contraseña es correcta
        if ($usuario && $usuario->password === $password) {
            Session::put('usuario_logeado', $usuario->documento);
            Session::put('usuario_nombre', $usuario->nombre ?? 'Cliente Scotiabank');
            
            return redirect('/dashboard');
        }

        return back()->with('error', 'Número de documento o contraseña incorrectos.');
    }

    public function cerrarSesion()
    {
        Session::forget('usuario_logeado');
        return redirect('/login');
    }

    public function procesarRegistro(Request $request) {
    // Insertamos directamente en la tabla clientes de Supabase
    \Illuminate\Support\Facades\DB::table('clientes')->insert([
        'documento' => $request->documento,
        'nombre'    => $request->nombre,
        'password'  => $request->password, // Lo guardamos simple para tu clase
    ]);

    // Redirigimos al login con un mensaje de éxito
    return redirect('/login')->with('success', 'Usuario registrado correctamente.');
    }
}