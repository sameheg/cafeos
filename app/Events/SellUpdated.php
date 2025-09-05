<?php

namespace App\Events;

use App\Transaction;
use App\User;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SellUpdated
{
    use Dispatchable, SerializesModels;

    public $transaction;
    public $user;
    public $changes;
    public $timestamp;

    public function __construct(Transaction $transaction, User $user, array $changes)
    {
        $this->transaction = $transaction;
        $this->user = $user;
        $this->changes = $changes;
        $this->timestamp = now();
    }
}

