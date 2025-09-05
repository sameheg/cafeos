<?php

namespace App\Providers;

use App\TranslationOverride;
use Illuminate\Support\ServiceProvider;

class TranslationOverrideServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->app->booted(function () {
            $locale = app()->getLocale();
            $overrides = TranslationOverride::where('locale', $locale)
                ->pluck('value', 'key')
                ->toArray();
            app('translator')->addLines($overrides, $locale);
        });
    }
}
