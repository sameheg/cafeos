<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Tenant;
use App\Events\TenantCreated;

class TenantInit extends Command
{
    protected $signature = 'tenant:init {name} {domain}';

    protected $description = 'Create a new tenant and provision its resources';

    public function handle(): int
    {
        $name = $this->argument('name');
        $domain = $this->argument('domain');
        $database = 'tenant_' . Str::slug($name, '_');

        DB::statement("CREATE DATABASE IF NOT EXISTS `{$database}`");

        $tenant = Tenant::create([
            'name' => $name,
            'domain' => $domain,
            'database' => $database,
        ]);

        // Run tenant migrations
        Artisan::call('tenants:artisan', [
            'artisanCommand' => 'migrate --force',
            '--tenant' => $tenant->id,
        ]);

        event(new TenantCreated($tenant));

        $this->info("Tenant {$name} initialised.");

        return self::SUCCESS;
    }
}
