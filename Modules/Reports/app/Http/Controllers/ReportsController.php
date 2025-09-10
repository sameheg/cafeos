<?php

namespace Modules\Reports\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;

class ReportsController extends Controller
{
    public function index(): View
    {
        /** @phpstan-var view-string $view */
        $view = 'reports::index';

        return view($view);
    }
}
