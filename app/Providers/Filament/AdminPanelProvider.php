<?php

namespace App\Providers\Filament;

use Filament\Facades\Filament;
use Filament\Panel;
use Illuminate\Support\ServiceProvider;

/**
 * Registers the main Filament admin panel for EliteSaaS.
 *
 * The provider exits gracefully when Filament is not installed so that
 * regular application executions (like unit tests) can run without the
 * package being present. Once Filament is installed the panel will be
 * available at `/admin` and will auto-discover resources, pages and
 * widgets from both the application and loaded modules.
 */
class AdminPanelProvider extends ServiceProvider
{
    public function boot(): void
    {
        // Avoid failing when the Filament package is not yet installed.
        if (! class_exists(Panel::class)) {
            return;
        }

        $panel = Panel::make()
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets');

        foreach (glob(base_path('Modules/*'), GLOB_ONLYDIR) as $modulePath) {
            $module = basename($modulePath);
            $filamentPath = $modulePath.'/app/Filament';

            if (is_dir("{$filamentPath}/Resources")) {
                $panel->discoverResources(in: "{$filamentPath}/Resources", for: "Modules\\\\{$module}\\\\Filament\\\\Resources");
            }

            if (is_dir("{$filamentPath}/Pages")) {
                $panel->discoverPages(in: "{$filamentPath}/Pages", for: "Modules\\\\{$module}\\\\Filament\\\\Pages");
            }

            if (is_dir("{$filamentPath}/Widgets")) {
                $panel->discoverWidgets(in: "{$filamentPath}/Widgets", for: "Modules\\\\{$module}\\\\Filament\\\\Widgets");
            }
        }

        $panel
            ->middleware([
                \App\Http\Middleware\EncryptCookies::class,
                \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
                \Illuminate\Session\Middleware\StartSession::class,
                \Illuminate\View\Middleware\ShareErrorsFromSession::class,
                \App\Http\Middleware\Authenticate::class,
            ])
            ->authMiddleware([
                \App\Http\Middleware\Authenticate::class,
            ]);

        Filament::registerPanels([$panel]);
    }
}
