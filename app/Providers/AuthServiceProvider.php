<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Modules\Core\Policies\BasePolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();
        $this->registerModulePolicies();
    }

    protected function registerModulePolicies(): void
    {
        foreach (glob(base_path('Modules/*/Policies/*Policy.php')) as $policyPath) {
            if (basename($policyPath) === 'BasePolicy.php') {
                continue;
            }

            $module = basename(dirname(dirname($policyPath)));
            $policyClass = 'Modules\\' . $module . '\\Policies\\' . basename($policyPath, '.php');

            if (method_exists($policyClass, 'modelClass')) {
                Gate::policy($policyClass::modelClass(), $policyClass);
            }
        }
    }
}
