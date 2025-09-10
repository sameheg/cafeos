<?php

namespace Modules\Rentals\Policies;

use Modules\Core\Policies\BasePolicy;
use Modules\Rentals\Models\Listing;

class ListingPolicy extends BasePolicy
{
    protected static string $model = Listing::class;
}
