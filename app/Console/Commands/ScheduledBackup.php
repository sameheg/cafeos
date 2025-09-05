<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use App\Models\BackupSetting;

class ScheduledBackup extends Command
{
    protected $signature = 'backup:scheduled';

    protected $description = 'Run backups based on configured settings';

    public function handle(): int
    {
        $settings = BackupSetting::first();
        if (! $settings) {
            $this->warn('No backup settings found.');
            return self::SUCCESS;
        }

        Artisan::call('backup:run');
        Artisan::call('backup:clean');

        DB::table('backup_logs')->insert([
            'status' => 'success',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $this->info('Backup completed.');
        return self::SUCCESS;
    }
}
