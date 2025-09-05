<?php

namespace App\Providers;

use App\TranslationOverride;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class TranslationOverrideServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->app->booted(function () {
            if (! Schema::hasTable('translation_overrides')) {
                return;
            }

            $locale = app()->getLocale();
            $overrides = TranslationOverride::where('locale', $locale)
                ->pluck('value', 'key')
                ->toArray();
            app('translator')->addLines($overrides, $locale);
        });
    }
}
