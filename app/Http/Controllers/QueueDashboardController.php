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
        $job = DB::table('failed_jobs')->where('id', $id)->first();
        if ($job) {
            DB::table('jobs')->insert([
                'queue' => $job->queue,
                'payload' => $job->payload,
                'attempts' => 0,
                'reserved_at' => null,
                'available_at' => now()->timestamp,
                'created_at' => now()->timestamp,
            ]);
            DB::table('failed_jobs')->where('id', $id)->delete();
        }

        return redirect()->route('queue.index');
    }

    public function destroy($id)
    {
        DB::table('failed_jobs')->where('id', $id)->delete();

        return redirect()->route('queue.index');
    }
}
