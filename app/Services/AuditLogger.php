<?php

namespace App\Services;

use Carbon\Carbon;

/**
 * Record critical actions in an append-only, hash-linked audit log.
 */
class AuditLogger
{
    protected string $file;

    public function __construct()
    {
        $this->file = config('security.audit_log.file');
    }

    /**
     * Persist an action to the audit log using a simple blockchain-style hash chain.
     */
    public function record(string $action, array $context = []): void
    {
        $entries = file_exists($this->file) ? file($this->file, FILE_IGNORE_NEW_LINES) : [];
        $prevHash = $entries ? json_decode(end($entries), true)['hash'] ?? '' : '';

        $payload = [
            'ts' => Carbon::now()->toIso8601String(),
            'action' => $action,
            'context' => $context,
            'prev_hash' => $prevHash,
        ];
        $payload['hash'] = hash('sha256', json_encode($payload));

        // Append the new payload atomically to preserve immutability
        file_put_contents($this->file, json_encode($payload) . PHP_EOL, FILE_APPEND | LOCK_EX);
    }

    /**
     * Remove log entries older than the retention policy allows.
     */
    public function prune(): void
    {
        $days = (int) config('security.audit_log.retention_days');
        if (! file_exists($this->file)) {
            return;
        }

        $cutoff = Carbon::now()->subDays($days);
        $lines = file($this->file, FILE_IGNORE_NEW_LINES);
        $filtered = array_filter($lines, function ($line) use ($cutoff) {
            $entry = json_decode($line, true);
            if (! isset($entry['ts'])) {
                return false;
            }
            return Carbon::parse($entry['ts'])->greaterThanOrEqualTo($cutoff);
        });

        file_put_contents($this->file, implode(PHP_EOL, $filtered) . (count($filtered) ? PHP_EOL : ''), LOCK_EX);
    }
}
