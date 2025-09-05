<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use App\User;
use App\Transaction;
use App\Events\SellUpdated;

class PosEditLogTest extends TestCase
{
    use RefreshDatabase;

    public function test_log_entry_created_on_sell_update(): void
    {
        Schema::disableForeignKeyConstraints();
        $user = User::factory()->create();
        $transaction = Transaction::create([
            'business_id' => 1,
            'location_id' => 1,
            'type' => 'sell',
            'status' => 'final',
            'payment_status' => 'paid',
            'contact_id' => 1,
            'transaction_date' => now(),
            'total_before_tax' => 0,
            'final_total' => 10,
            'created_by' => $user->id,
        ]);
        Schema::enableForeignKeyConstraints();

        event(new SellUpdated($transaction, $user, ['final_total' => ['old' => 10, 'new' => 15]]));

        $this->assertDatabaseHas('pos_edit_logs', [
            'transaction_id' => $transaction->id,
            'user_id' => $user->id,
        ]);
    }
}
