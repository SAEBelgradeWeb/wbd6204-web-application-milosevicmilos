<?php

namespace App\Providers;

use App\Models\Appliance;
use App\Models\Building;
use App\Models\Room;
use App\Models\User;
use App\Policies\AppliancePolicy;
use App\Policies\RoomPolicy;
use App\Policies\UserPolicy;
use App\Policies\BuildingPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

final class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        User::class => UserPolicy::class,
        Building::class => BuildingPolicy::class,
        Appliance::class => AppliancePolicy::class,
        Room::class => RoomPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->registerPolicies();
    }
}
