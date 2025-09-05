<?php

namespace App\Listeners;

use App\Events\SellUpdated;

class LogSellUpdate
{
    public function handle(SellUpdated $event)
    {
        $old = [];
        $new = [];
        foreach ($event->changes as $field => $values) {
            if (is_array($values) && array_key_exists('old', $values) && array_key_exists('new', $values)) {
                $old[$field] = $values['old'];
                $new[$field] = $values['new'];
            }
        }

        activity()
            ->performedOn($event->transaction)
            ->causedBy($event->user)
            ->withProperties(['old' => $old, 'attributes' => $new, 'timestamp' => $event->timestamp])
            ->log('sell_updated');
    }
}

