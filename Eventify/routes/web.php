<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HomeController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::post('/login', [LoginController::class, 'login']);
Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

// Middleware auth, ya que 'admin' no existe, se elimina
Route::middleware(['auth'])->group(function () {
    Route::get('/admin/dashboard', [UserController::class, 'dashboard'])->name('admin.dashboard');
    Route::post('/admin/users/{id}/activate', [UserController::class, 'activate'])->name('admin.users.activate');
    Route::post('/admin/users/{id}/deactivate', [UserController::class, 'deactivate'])->name('admin.users.deactivate');
});