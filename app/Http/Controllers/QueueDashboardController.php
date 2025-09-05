<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class QueueDashboardController extends Controller
{
    public function index()
    {
        $failedJobs = DB::table('failed_jobs')->orderByDesc('failed_at')->get();

        return view('queue.dashboard', compact('failedJobs'));
    }
}
