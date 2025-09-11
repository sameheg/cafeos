<?php

namespace App\Console\Commands;

use App\Events\TenantCreated;
use App\Models\Tenant;
use Illuminate\Console\Command;
use Spatie\Multitenancy\Actions\MigrateTenantAction;

class TenantInit extends Command
{
    protected $signature = 'tenant:init {name} {domain}';

    protected $description = 'Create a tenant and run its migrations';

    public function handle(): int
    {
        $name = $this->argument('name');
        $domain = $this->argument('domain');
        $database = database_path("tenant_{$domain}.sqlite");

        $tenant = Tenant::create([
            'name' => $name,
            'domain' => $domain,
            'database' => $database,
        ]);

        if (! file_exists($database)) {
            touch($database);
        }

        app(MigrateTenantAction::class)->execute($tenant);

        event(new TenantCreated($tenant));

        $this->info("Tenant {$tenant->name} initialized");

        return self::SUCCESS;
    }
}
