<?php

namespace Modules\Sync\Console;

use Illuminate\Console\Command;
use Modules\Sync\Services\QueueSyncService;

class SyncQueueCommand extends Command
{
    protected $signature = 'sync:queue {action=list : list or retry pending items}';

    protected $description = 'Inspect pending sync items or retry processing';

    public function handle(QueueSyncService $service): int
    {
        $action = $this->argument('action');

        if ($action === 'retry') {
            $service->process();
            $this->info('Retry attempt completed.');
            return Command::SUCCESS;
        }

        $items = $service->getQueue();
        if (empty($items)) {
            $this->info('No pending items.');
            return Command::SUCCESS;
        }

        foreach ($items as $item) {
            $this->line(sprintf(
                '#%d %s %s | failed_at: %s | error: %s',
                $item['id'],
                $item['method'],
                $item['url'],
                $item['failed_at'] ?? 'n/a',
                $item['error_message'] ?? 'n/a'
            ));
        }

        return Command::SUCCESS;
    }
}
