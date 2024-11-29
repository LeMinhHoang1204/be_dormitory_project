<?php

namespace App\Providers;

use App\Models\Building;
use App\Models\Notification;
use App\Models\Room;
use app\Models\User;
use App\Policies\BuildingPolicy;
use App\Policies\NotificationPolicy;
use App\Policies\RoomPolicy;
use app\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

//use Illuminate\Support\ServiceProvider;


class   AuthServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */

    protected $policies = [
        User::class => UserPolicy::class, // Mapping User model to UserPolicy
        Notification::class => NotificationPolicy::class,
        Building::class => BuildingPolicy::class,
        Room::class => RoomPolicy::class,
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
        $this->registerPolicies();
    }
}
