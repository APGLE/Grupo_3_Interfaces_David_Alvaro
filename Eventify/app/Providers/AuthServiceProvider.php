<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Models\User;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        // Define the 'admin-access' permission
        Gate::define('admin-access', function (User $user) {
            // Depuración: Verificar información del usuario
            if (is_null($user)) {
                \Log::debug('Gate check: Usuario no autenticado.');
                return false;
            }

            \Log::debug('Gate check: Usuario autenticado con rol: ' . $user->role);
            // Asegurarse de que el rol sea 'admin', ignorando mayúsculas/minúsculas y espacios
            return strtolower(trim($user->role)) === 'admin';
        });
    }
}
