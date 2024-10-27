<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use app\Models\User;
use app\Policies\UserPolicy;

class   AuthServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */

    protected $policies = [
        User::class => UserPolicy::class, // Mapping User model to UserPolicy
    ];

    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
