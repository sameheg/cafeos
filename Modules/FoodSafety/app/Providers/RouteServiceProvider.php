<?php

namespace Modules\FoodSafety\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    protected string $name = 'FoodSafety';

    public function map(): void
    {
        $this->mapApiRoutes();
    }

    protected function mapApiRoutes(): void
    {
        Route::middleware('api')
            ->prefix('api/v1/foodsafety')
            ->name('api.foodsafety.')
            ->group(module_path($this->name, '/routes/api.php'));
    }
}
