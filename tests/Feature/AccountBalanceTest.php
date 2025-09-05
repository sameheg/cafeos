<?php

namespace Tests\Feature;

use App\Account;
use App\AccountTransaction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class AccountBalanceTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        putenv('DB_CONNECTION=sqlite');
        putenv('DB_DATABASE=:memory:');
        parent::setUp();
    }

    public function test_balance_calculated_sequentially_for_same_day_transactions()
    {
        $account = Account::create([
            'business_id' => 1,
            'name' => 'Test Account',
            'account_number' => '12345',
            'created_by' => 1,
        ]);

        $date = '2023-01-01 00:00:00';

        $t1 = AccountTransaction::create([
            'account_id' => $account->id,
            'type' => 'credit',
            'amount' => 100,
            'operation_date' => $date,
            'created_by' => 1,
        ]);

        $t2 = AccountTransaction::create([
            'account_id' => $account->id,
            'type' => 'debit',
            'amount' => 20,
            'operation_date' => $date,
            'created_by' => 1,
        ]);

        $t3 = AccountTransaction::create([
            'account_id' => $account->id,
            'type' => 'credit',
            'amount' => 50,
            'operation_date' => $date,
            'created_by' => 1,
        ]);

        $start_date = $date;
        $bal_before_start_date = 0;

        $rows = [$t1, $t2, $t3];
        $balances = [];

        foreach ($rows as $row) {
            $current_bal = AccountTransaction::where('account_id', $row->account_id)
                ->where('operation_date', '>=', $start_date)
                ->where(function ($q) use ($row) {
                    $q->where('operation_date', '<', $row->operation_date)
                        ->orWhere(function ($q2) use ($row) {
                            $q2->where('operation_date', $row->operation_date)
                                ->where('id', '<=', $row->id);
                        });
                })
                ->select(DB::raw("SUM(IF(type='credit', amount, -1 * amount)) as balance"))
                ->first()->balance;
            $balances[] = $bal_before_start_date + $current_bal;
        }

        $this->assertEquals([100, 80, 130], $balances);
    }
}
