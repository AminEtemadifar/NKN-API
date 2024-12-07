<?php

namespace App\Providers;

use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        Passport::ignoreRoutes();
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {

        // Define gates for roles
        $roles = Role::all();
        foreach ($roles as $role) {
            Gate::define($role->key, function (User $user) use ($role) {
                return $user->hasRole($role->key);
            });
        }
    }
}
