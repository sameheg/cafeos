<?php

namespace App\Listeners;

use App\Events\SellUpdated;
use App\PosEditLog;

class SavePosEditLog
{
    public function handle(SellUpdated $event): void
    {
        if (!empty($event->changes)) {
            PosEditLog::create([
                'transaction_id' => $event->transaction->id,
                'user_id' => $event->user->id,
                'changes' => $event->changes,
                'edited_at' => $event->timestamp,
            ]);
        }
    }
}
