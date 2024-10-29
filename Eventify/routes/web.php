<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Auth\RegisterController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Ruta raíz con logout y redirección
Route::get('/', function () {
    // Desautenticar al usuario si está autenticado y redirigir a bienvenida
    if (Auth::check()) {
        Auth::logout(); // Cierra la sesión si está autenticado
        return redirect('/'); // Redirige a la raíz después de desloguear
    }
    return view('welcome'); // Si no está autenticado, muestra la bienvenida
});

// Ruta de inicio de sesión (LoginController dentro de Auth)
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Rutas de registro y autenticación (estándar de Laravel)
Auth::routes();

// Ruta de inicio para usuarios autenticados
Route::get('/home', [HomeController::class, 'index'])->name('home');

// Ruta para el login
Route::post('/login', [LoginController::class, 'login']);

// Habilitar rutas de autenticación con verificación de correo
Auth::routes(['verify' => true]);

// Ruta protegida por verificación de correo
Route::get('/home', [HomeController::class, 'index'])
     ->name('home')
     ->middleware('verified');

// Ruta para la verificación del correo electrónico usando el controlador predeterminado de Laravel
Route::get('/email/verify/{id}/{hash}', function (Request $request) {
    // Encontrar el usuario usando el ID de la ruta
    $user = \App\Models\User::findOrFail($request->route('id'));

    // Verificar si el hash proporcionado coincide con el hash del email
    if (!hash_equals((string) $request->route('hash'), (string) sha1($user->email))) {
        return redirect('/')->withErrors(['message' => 'The verification link is invalid.']);
    }

    // Verificar si el correo ya ha sido verificado
    if ($user->hasVerifiedEmail()) {
        return redirect('/home')->with('message', 'Your email is already verified.');
    }

    // Marcar el email como verificado en la base de datos
    $user->markEmailAsVerified();

    return redirect('/home')->with('success', 'Email verified successfully!');
})->middleware(['signed'])->name('verification.verify');

// Middleware auth, ya que 'admin' no existe, se elimina
Route::middleware(['auth'])->group(function () {
    Route::get('/admin/dashboard', [UserController::class, 'dashboard'])->name('admin.dashboard');
    Route::post('/admin/users/{id}/activate', [UserController::class, 'activate'])->name('admin.users.activate');
    Route::post('/admin/users/{id}/deactivate', [UserController::class, 'deactivate'])->name('admin.users.deactivate');
    Route::get('/admin/users/{id}/edit', [UserController::class, 'edit'])->name('admin.users.edit');
    Route::put('/admin/users/{id}', [UserController::class, 'update'])->name('admin.users.update');
    Route::delete('/admin/users/{id}', [UserController::class, 'destroy'])->name('admin.users.destroy');
});
