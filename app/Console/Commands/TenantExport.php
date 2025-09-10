<?php

namespace App\Console\Commands;

use App\Models\AuditRequest;
use App\Support\Backup\Anonymizer;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class TenantExport extends Command
{
    /** @var string */
    protected $signature = 'tenant:export {tenant_id} {--path=}';

    /** @var string */
    protected $description = 'Export tenant data with anonymized sensitive fields';

    public function handle(Anonymizer $anonymizer): int
    {
        $tenantId = (int) $this->argument('tenant_id');
        $path = $this->option('path') ?? storage_path("exports/tenant-{$tenantId}.json");

        $tables = $this->tablesWithTenantId();

        $export = [];
        foreach ($tables as $table) {
            $rows = DB::table($table)
                ->where('tenant_id', $tenantId)
                ->get()
                ->map(fn ($row) => $anonymizer->anonymize((array) $row))
                ->toArray();

            if ($rows) {
                $export[$table] = $rows;
            }
        }

        if (! is_dir(dirname($path))) {
            mkdir(dirname($path), 0755, true);
        }
        file_put_contents($path, json_encode($export, JSON_PRETTY_PRINT));

        AuditRequest::create([
            'tenant_id' => $tenantId,
            'action' => 'export',
            'status' => 'completed',
            'requested_at' => Carbon::now(),
            'processed_at' => Carbon::now(),
            'expires_at' => Carbon::now()->addDays(30),
        ]);

        $this->info("Tenant {$tenantId} export written to {$path}");

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
