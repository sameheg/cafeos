<?php

namespace App\Providers;

use App\Services\PaymentProviders\LemonSqueezy\LemonSqueezyProvider;
use App\Services\PaymentProviders\Offline\OfflineProvider;
use App\Services\PaymentProviders\Paddle\PaddleProvider;
use App\Services\PaymentProviders\PaymentService;
use App\Services\PaymentProviders\Stripe\StripeProvider;
use App\Services\TenantContext;
use App\Services\UserVerificationService;
use App\Services\VerificationProviders\TwilioProvider;
use App\Services\Audit\AuditTrailService;
use App\Services\Audit\BlockchainAuditTrailService;
use App\Services\Audit\LogAuditTrailService;
use App\Services\Compliance\GdprComplianceService;
use App\Services\Compliance\PciComplianceService;
use Filament\Support\Assets\Js;
use Filament\Support\Facades\FilamentAsset;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        if ($this->app->environment('local')) {
            $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
            $this->app->register(TelescopeServiceProvider::class);
        }

        // payment providers
        $this->app->tag([
            StripeProvider::class,
            PaddleProvider::class,
            LemonSqueezyProvider::class,
            OfflineProvider::class,
        ], 'payment-providers');

        $this->app->bind(PaymentService::class, function () {
            return new PaymentService(...$this->app->tagged('payment-providers'));
        });

        $this->app->singleton(TenantContext::class, TenantContext::class);

        // verification providers
        $this->app->tag([
            TwilioProvider::class,
        ], 'verification-providers');

        $this->app->afterResolving(UserVerificationService::class, function (UserVerificationService $service) {
            $service->setVerificationProviders(...$this->app->tagged('verification-providers'));
        });

        $this->app->singleton(AuditTrailService::class, function () {
            if (config('audit.blockchain_enabled')) {
                return new BlockchainAuditTrailService();
            }

            return new LogAuditTrailService();
        });

        $this->app->singleton(GdprComplianceService::class);
        $this->app->singleton(PciComplianceService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        FilamentAsset::register([
            Js::make('components-script', __DIR__.'/../../resources/js/components.js'),
        ]);
    }
}
