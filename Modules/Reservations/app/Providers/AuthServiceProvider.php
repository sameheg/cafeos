<?php
namespace Modules\Reservations\App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Modules\Reservations\App\Models\Reservation;
use Modules\Reservations\App\Policies\ReservationPolicy;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Reservation::class => ReservationPolicy::class,
    ];

    public function boot(): void
    {
        $this->registerPolicies();
    }
}
