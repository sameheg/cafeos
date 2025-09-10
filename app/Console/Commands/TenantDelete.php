<?php

namespace App\Console\Commands;

use App\Models\AuditRequest;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class TenantDelete extends Command
{
    /** @var string */
    protected $signature = 'tenant:delete {tenant_id}';

    /** @var string */
    protected $description = 'Delete all data for a tenant';

    public function handle(): int
    {
        $tenantId = (int) $this->argument('tenant_id');

        $tables = $this->tablesWithTenantId();
        foreach ($tables as $table) {
            DB::table($table)->where('tenant_id', $tenantId)->delete();
        }

        AuditRequest::create([
            'tenant_id' => $tenantId,
            'action' => 'delete',
            'status' => 'completed',
            'requested_at' => Carbon::now(),
            'processed_at' => Carbon::now(),
            'expires_at' => Carbon::now()->addDays(30),
        ]);

        $this->info("Tenant {$tenantId} data deleted");

        return self::SUCCESS;
    }

    /**
     * Get tables that contain a tenant_id column.
     *
     * @return array<int, string>
     */
    protected function tablesWithTenantId(): array
    {
        $connection = DB::connection();
        $driver = $connection->getDriverName();
        $tables = [];

        if ($driver === 'mysql') {
            $result = $connection->select('SHOW TABLES');
            $tables = array_map(fn ($row) => array_values((array) $row)[0], $result);
        } elseif ($driver === 'sqlite') {
            $result = $connection->select("SELECT name FROM sqlite_master WHERE type='table' AND name NOT LIKE 'sqlite_%'");
            $tables = array_map(fn ($row) => $row->name, $result);
        }

        return array_filter($tables, fn ($table) => Schema::hasColumn($table, 'tenant_id'));
    }
}
