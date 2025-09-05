<?php

namespace Modules\HR\Services;

use App\Models\User;
use Modules\HR\Entities\Payroll;

class PayrollService
{
    public function calculate(User $user, string $month, float $baseAmount): Payroll
    {
        $payroll = Payroll::updateOrCreate(
            ['user_id' => $user->id, 'month' => $month],
            ['amount' => $baseAmount, 'status' => 'pending']
        );

        return $payroll;
    }
}
