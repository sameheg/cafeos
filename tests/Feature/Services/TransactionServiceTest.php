<?php

namespace Tests\Feature\Services;

use App\Constants\TransactionStatus;
use App\Events\Payment\PaymentFailed;
use App\Models\Currency;
use App\Models\PaymentProvider;
use App\Models\Transaction;
use App\Services\TransactionService;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Str;
use Tests\Feature\FeatureTest;

class TransactionServiceTest extends FeatureTest
{
    public function test_dispatches_payment_failed_event(): void
    {
        Event::fake();

        $user = $this->createUser();
        $tenant = $this->createTenant();
        $currency = Currency::first();
        $provider = PaymentProvider::first();

        $transaction = Transaction::create([
            'uuid' => (string) Str::uuid(),
            'user_id' => $user->id,
            'amount' => 100,
            'total_tax' => 0,
            'total_discount' => 0,
            'total_fees' => 0,
            'currency_id' => $currency->id,
            'status' => TransactionStatus::PENDING->value,
            'payment_provider_id' => $provider->id,
            'payment_provider_status' => 'pending',
            'payment_provider_transaction_id' => 'tx_1',
            'tenant_id' => $tenant->id,
        ]);

        $service = app()->make(TransactionService::class);
        $service->updateTransaction($transaction, 'failed', TransactionStatus::FAILED);

        Event::assertDispatched(PaymentFailed::class, function ($event) use ($transaction) {
            return $event->transaction->id === $transaction->id;
        });
    }
}
