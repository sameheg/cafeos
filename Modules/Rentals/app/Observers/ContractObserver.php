<?php

namespace Modules\Rentals\Observers;

use Illuminate\Support\Facades\Event;
use Modules\Rentals\Models\Contract;

class ContractObserver
{
    public function created(Contract $contract): void
    {
        Event::dispatch('rentals.contract.signed@v1', [
            'contract_id' => $contract->id,
            'renter_id' => $contract->renter_id,
        ]);
    }
}
