<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\KdsMetric;

class KdsMetricsController extends Controller
{
    /**
     * Return recent KDS metrics.
     */
    public function index()
    {
        return ['metrics' => KdsMetric::latest()->take(100)->get()];
    }
}
