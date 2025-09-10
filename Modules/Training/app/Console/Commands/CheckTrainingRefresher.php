<?php

namespace Modules\Training\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Modules\Training\Models\TrainingCompletion;

class CheckTrainingRefresher extends Command
{
    protected $signature = 'training:check-refresher';

    protected $description = 'Notify managers when staff require refresher training';

    public function handle(): int
    {
        $expiring = TrainingCompletion::whereNotNull('expires_at')
            ->where('expires_at', '<=', now())
            ->get();

        foreach ($expiring as $completion) {
            Log::info('Training refresher needed', [
                'user_id' => $completion->user_id,
                'training_material_id' => $completion->training_material_id,
            ]);
        }

        $this->info('Checked training refreshers: '.count($expiring));

        return self::SUCCESS;
    }
}
