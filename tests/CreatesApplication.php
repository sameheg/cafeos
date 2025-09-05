<?php

namespace Tests;

use Illuminate\Contracts\Console\Kernel;

trait CreatesApplication
{
    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        require_once __DIR__.'/stubs/MenusServiceProvider.php';
        require_once __DIR__.'/stubs/RouteServiceProvider.php';
        $basePath = dirname(__DIR__);
        file_put_contents($basePath.'/modules_statuses.json', '{}');

        $app = require $basePath.'/bootstrap/app.php';

        $app->make(Kernel::class)->bootstrap();

        return $app;
    }
}
