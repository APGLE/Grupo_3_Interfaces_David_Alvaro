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
        $credentials = $request->only('email', 'password');
        $user = \App\Models\User::where('email', $request->email)->first();

        if ($user && !$user->email_confirmed) {
            return back()->with('error', 'Debes confirmar tu email antes de iniciar sesión.');
        }

        if ($user && !$user->actived) {
            return back()->with('error', 'Tu cuenta debe ser activada por el administrador.');
        }

        if (Auth::attempt($credentials)) {
            return redirect()->intended('/dashboard');
        }

        return back()->with('error', 'Credenciales incorrectas.');
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }
}
