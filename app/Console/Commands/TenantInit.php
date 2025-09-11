<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Tenant;

class TenantInit extends Command
{
    protected $signature = 'tenant:init {name} {domain}';

    protected $description = 'Provision a new tenant';

    public function handle(): int
    {
        $name = $this->argument('name');
        $domain = $this->argument('domain');
        $db = env('TENANT_DB_PREFIX', 'tenant_') . Str::snake($domain);

        DB::statement("CREATE DATABASE IF NOT EXISTS `{$db}`");

        $tenant = Tenant::create([
            'name' => $name,
            'domain' => $domain,
            'database' => $db,
        ]);

        config(['database.connections.tenant.database' => $db]);
        Artisan::call('migrate', [
            '--database' => 'tenant',
            '--path' => 'database/migrations',
            '--force' => true,
        ]);

        $this->info("Tenant {$tenant->name} initialized.");
        return self::SUCCESS;
    }
}
