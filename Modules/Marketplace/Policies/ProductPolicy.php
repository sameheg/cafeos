<?php

namespace Modules\Marketplace\Policies;

use Modules\Core\Policies\BasePolicy;
use Modules\Marketplace\Models\Product;

class ProductPolicy extends BasePolicy
{
    protected static string $model = Product::class;
}
