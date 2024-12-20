<?php

namespace App\Providers;

use App\Models\Activity;
use App\Models\Asset;
use App\Models\Building;
use App\Models\DetailInvoice;
use App\Models\Invoice;
use App\Models\Notification;
use App\Models\NotificationRecipient;
use App\Models\RegistrationActivity;
use App\Models\Request;
use App\Models\Residence;
use App\Models\Room;
use App\Models\RoomAsset;
use App\Models\Student;
use app\Models\User;
use App\Models\Violation;
use App\Policies\ActivityPolicy;
use App\Policies\AssetPolicy;
use App\Policies\BuildingPolicy;
use App\Policies\DetailInvoicePolicy;
use App\Policies\InvoicePolicy;
use App\Policies\NotificationPolicy;
use App\Policies\RegistrationActivityPolicy;
use App\Policies\RequestPolicy;
use App\Policies\ResidencePolicy;
use App\Policies\RoomAssetPolicy;
use App\Policies\RoomPolicy;
use App\Policies\StudentPolicy;
use app\Policies\UserPolicy;
use App\Policies\ViolationPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
//use Illuminate\Support\ServiceProvider;


class   AuthServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */

    protected $policies = [
        User::class => UserPolicy::class, // Mapping User model to UserPolicy
        Notification::class => NotificationPolicy::class,
        NotificationRecipient::class => NotificationRecipient::class,

        Student::class => StudentPolicy::class,

        Building::class => BuildingPolicy::class,
        Room::class => RoomPolicy::class,
        Residence::class => ResidencePolicy::class,

        Asset::class => AssetPolicy::class,
        RoomAsset::class => RoomAssetPolicy::class,

        Request::class => RequestPolicy::class,

        Invoice::class => InvoicePolicy::class,
        DetailInvoice::class => DetailInvoicePolicy::class,

        Activity::class => ActivityPolicy::class,
        RegistrationActivity::class => RegistrationActivityPolicy::class,

        Violation::class => ViolationPolicy::class,
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
        Gate::define('update', [ActivityPolicy::class, 'update']);
        Gate::define('store-registration-activity', [RegistrationActivityPolicy::class, 'store']);

    }
}
