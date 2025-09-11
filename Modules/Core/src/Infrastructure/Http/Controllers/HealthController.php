<?php

namespace Modules\Core\Infrastructure\Http\Controllers;

use Illuminate\Routing\Controller;
use Modules\Core\Application\Health\HealthStatusQuery;

class HealthController extends Controller
{
    public function __invoke(HealthStatusQuery $query)
    {
        return response()->json($query->handle());
    }
}
