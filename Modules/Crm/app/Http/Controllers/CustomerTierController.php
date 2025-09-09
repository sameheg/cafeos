<?php

namespace Modules\Crm\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Crm\Contracts\CustomerProfileServiceInterface;

class CustomerTierController extends Controller
{
    public function __construct(private CustomerProfileServiceInterface $profiles)
    {
    }

    public function upgrade(int|string $customerId)
    {
        $tier = $this->profiles->upgradeTier($customerId);
        return response()->json(['tier' => $tier->value]);
    }

    public function downgrade(int|string $customerId)
    {
        $tier = $this->profiles->downgradeTier($customerId);
        return response()->json(['tier' => $tier->value]);
    }
}
