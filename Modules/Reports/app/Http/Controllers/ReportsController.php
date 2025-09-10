<?php

namespace Modules\Reports\Http\Controllers;

use App\Http\Controllers\Controller;

class ReportsController extends Controller
{
    public function index()
    {
        return view('reports::index');
    }
}
