<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Handle a login request to the application with additional checks.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
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
            return redirect()->intended($this->redirectPath()); // Redirigir a la ruta de inicio
        }

        // Si las credenciales son incorrectas
        return back()->with('error', 'Credenciales incorrectas.');
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        $this->guard()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
