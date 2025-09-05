<?php
// app/Backup/Cleanup/KeepLatestBackups.php

namespace App\Backup\Cleanup;

use Spatie\Backup\Tasks\Cleanup\CleanupStrategy;
use Spatie\Backup\BackupDestination\BackupCollection;
use Spatie\Backup\BackupDestination\BackupDestination;
use App\Models\BackupSetting;

class KeepLatestBackups extends CleanupStrategy
{
    public function deleteOldBackups(BackupCollection $backups)
    {
        // Sort the backups by date in descending order
        $backups = $backups->sortByDesc('date');

        // Keep only the configured number of backups
        $retain = optional(BackupSetting::first())->retain_copies ?? 5;
        $backupsToKeep = $backups->slice(0, $retain);

        // Delete old backups except those to keep
        foreach ($backups as $backup) {
            if (!$backupsToKeep->contains($backup)) {
                $backup->delete();
            }
        }
    }
}
