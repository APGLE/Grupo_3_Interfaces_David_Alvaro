<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Event;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');

        // Definir el permiso 'admin-access' basado en el nombre del usuario
        Gate::define('admin-access', function ($user) {
            return strtolower(trim($user->role)) === 'a';
        });
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $users = User::where('deleted', 0)->get();
        $events = Event::all();    
        return view('home', compact('users', 'events'));
    }
}
