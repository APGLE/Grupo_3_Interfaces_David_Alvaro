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
            return strtolower(trim($user->role)) === 'admin'; // Asegurarse de que el rol sea 'admin', ignorando mayúsculas/minúsculas y espacios
        });
    }
}
