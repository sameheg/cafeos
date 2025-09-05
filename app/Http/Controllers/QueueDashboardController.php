<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class QueueDashboardController extends Controller
{
    public function index()
    {
        $failedJobs = DB::table('failed_jobs')->orderByDesc('failed_at')->get();
        $pendingJobs = DB::table('jobs')->orderByDesc('available_at')->get();
        $queues = DB::table('jobs')
            ->select('queue', DB::raw('count(*) as pending'))
            ->groupBy('queue')
            ->get();

        return view('queue.dashboard', compact('failedJobs', 'pendingJobs', 'queues'));
    }

    public function retry($id)
    {
        \Artisan::call('queue:retry', ['id' => [$id]]);

        return redirect()->route('queue.index');
    }

    public function destroy($id)
    {
        \Artisan::call('queue:forget', ['id' => $id]);

        return redirect()->route('queue.index');
    }
}
