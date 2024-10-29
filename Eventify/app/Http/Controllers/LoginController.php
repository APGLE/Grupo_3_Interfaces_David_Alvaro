<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // Validar las credenciales
        $credentials = $request->only('email', 'password');
        $user = \App\Models\User::where('email', $request->email)->first();

        // Verificar si el usuario existe y si su correo está confirmado
        if ($user && !$user->hasVerifiedEmail()) {
            return back()->with('error', 'Debes confirmar tu email antes de iniciar sesión.');
        }

        // Verificar si la cuenta está activa
        if ($user && !$user->actived) {
            return back()->with('error', 'Tu cuenta debe ser activada por el administrador.');
        }

        // Intentar iniciar sesión
        if (Auth::attempt($credentials)) {
            return redirect()->intended('/home'); // Redirigir a la ruta de inicio
        }

        // Si las credenciales son incorrectas
        return back()->with('error', 'Credenciales incorrectas.');
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }
}