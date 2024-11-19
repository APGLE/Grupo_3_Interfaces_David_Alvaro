<?php

use App\Http\Controllers\MailController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\EventController;

// Rutas de registro
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// Rutas de inicio de sesión
Route::post('/login', [LoginController::class, 'login']);

// Rutas de autenticación con verificación de correo
Auth::routes(['verify' => true]);

// Ruta protegida por verificación de correo
Route::get('/home', [HomeController::class, 'index'])
     ->name('home')
     ->middleware('verified');

// Ruta de verificación de correo
Route::get('/email/verify/{id}/{hash}', function (Request $request) {
    $user = \App\Models\User::findOrFail($request->route('id'));

    if (!hash_equals((string) $request->route('hash'), (string) sha1($user->email))) {
        return redirect('/')->withErrors(['message' => 'El enlace de verificación no es válido.']);
    }

    if ($user->hasVerifiedEmail()) {
        return redirect('/home')->with('message', 'Su correo ya ha sido verificado.');
    }

    $user->markEmailAsVerified();
    $user->email_confirmed = 1;
    $user->save();

    return redirect('/home')->with('success', '¡Correo verificado exitosamente!');
})->middleware(['signed'])->name('verification.verify');

// Rutas del administrador protegidas por autenticación
Route::middleware(['auth'])->group(function () {
    Route::get('/admin/dashboard', [UserController::class, 'dashboard'])->name('admin.dashboard');
    Route::post('/admin/users/{id}/activate', [UserController::class, 'activate'])->name('admin.users.activate');
    Route::post('/admin/users/{id}/deactivate', [UserController::class, 'deactivate'])->name('admin.users.deactivate');
    Route::get('/admin/users/{id}/edit', [UserController::class, 'edit'])->name('admin.users.edit');
    Route::put('/admin/users/{id}', [UserController::class, 'update'])->name('admin.users.update');
    Route::delete('/admin/users/{id}', [UserController::class, 'destroy'])->name('admin.users.destroy');
});

// Ruta para la página de inicio
Route::get('/', function () {
    return view('welcome');
});

//Ruta para el Blade Eventods
Route::get('/events/create', function () {
    return view('events.create_event');
});
//ruta para los eventos post
Route::post('/events/create', [EventController::class, 'store']);
Route::get('/events/{id}', [EventController::class, 'show'])->name('events.show');
Route::get('/events/{id}/edit', [EventController::class, 'edit'])->name('events.edit');


Route::delete('/events/{id}', [EventController::class, 'destroy'])->name('events.destroy');
Route::put('/events/{id}', [EventController::class, 'update'])->name('events.update');

Route::get('/musica', [EventController::class, 'musica'])->name('musica');
Route::get('/deporte', [EventController::class, 'deporte'])->name('deporte');
Route::get('/tecnologia', [EventController::class, 'tecnologia'])->name('tecnologia');

//Para el envio del pdf con el correo
Route::post('/enviar.pdf',[MailController::class, 'enviarpdf'])->name('enviar.pdf');

Route::post('/events/{event}/subscribe', [EventController::class, 'subscribe'])->name('events.subscribe');
Route::post('/events/{event}/unsubscribe', [EventController::class, 'unsubscribe'])->name('events.unsubscribe');
