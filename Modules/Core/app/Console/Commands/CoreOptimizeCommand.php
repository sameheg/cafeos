<?php

namespace Modules\Core\Console\Commands;

use Illuminate\Console\Command;

class CoreOptimizeCommand extends Command
{
    protected $signature = 'core:optimize';

    protected $description = 'Optimize core caches and configuration';

    public function handle(): int
    {
        $this->call('config:cache');
        $this->call('route:cache');
        $this->call('view:cache');
        $this->info('Core optimized');

        return self::SUCCESS;
    }
}
