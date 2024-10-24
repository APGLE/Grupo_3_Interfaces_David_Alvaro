<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\LoginController;
<<<<<<< Updated upstream
use App\Http\Controllers\UserController;


=======
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
>>>>>>> Stashed changes

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
| Aquí es donde puedes registrar rutas web para tu aplicación. Estas 
| rutas se cargan a través del RouteServiceProvider y todas se asignan 
| al grupo de middleware "web". 
*/

// Ruta de inicio
Route::get('/', function () {
    return view('welcome'); // Página principal
});

// Ruta para el registro
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

<<<<<<< Updated upstream
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/dashboard', [UserController::class, 'dashboard'])->name('admin.dashboard');
    Route::post('/admin/users/{id}/activate', [UserController::class, 'activate'])->name('admin.users.activate');
    Route::post('/admin/users/{id}/deactivate', [UserController::class, 'deactivate'])->name('admin.users.deactivate');
});
=======
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
>>>>>>> Stashed changes
