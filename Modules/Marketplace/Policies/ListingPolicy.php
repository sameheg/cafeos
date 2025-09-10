<?php

namespace Modules\Marketplace\Policies;

use Modules\Core\Policies\BasePolicy;
use Modules\Marketplace\Models\Listing;

class ListingPolicy extends BasePolicy
{
    protected static string $model = Listing::class;
}
