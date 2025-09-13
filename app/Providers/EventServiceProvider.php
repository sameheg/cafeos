<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        \App\Events\SitemapChanged::class => [
            \App\Listeners\GenerateSitemap::class,
        ],
        \App\Events\Order\Ordered::class => [
            \App\Listeners\Order\SendOrderNotification::class,
        ],
        \App\Events\Subscription\InvoicePaymentFailed::class => [
            \App\Listeners\Subscription\SendInvoicePaymentFailedNotification::class,
        ],
        \App\Events\Subscription\SubscriptionCancelled::class => [
            \App\Listeners\Subscription\SendSubscriptionCancellationNotification::class,
        ],
        \App\Events\Subscription\Subscribed::class => [
            \App\Listeners\Subscription\SendSubscribedNotification::class,
        ],
        \App\Events\Tenant\UserInvitedToTenant::class => [
            \App\Listeners\Tenant\SendUserInvitationNotification::class,
        ],
        \App\Events\User\UserPhoneVerified::class => [
            \App\Listeners\User\ActivateSubscriptionsPendingUserVerification::class,
        ],
        \App\Events\User\UserSeen::class => [
            \App\Listeners\User\UpdateUserLastSeen::class,
        ],
        \Illuminate\Auth\Events\Registered::class => [
            \App\Listeners\User\CreateTenantIfNeeded::class,
        ],
        \App\Events\Order\OrderCreated::class => [
            \App\Listeners\Order\SendOrderCreatedWebhook::class,
        ],
        \App\Events\Payment\PaymentFailed::class => [
            \App\Listeners\Payment\SendPaymentFailedWebhook::class,
        ],
        \App\Events\Device\DeviceAlert::class => [
            \App\Listeners\Device\SendDeviceAlertWebhook::class,
        ],
        \App\Events\Reservation\ReservationConfirmed::class => [
            \App\Listeners\Reservation\SendReservationConfirmedWebhook::class,
        ],
    ];
}
