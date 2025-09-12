<?php

namespace Modules\Jobs\Http\Controllers;

use Illuminate\Support\Facades\Cache;
use Modules\Jobs\Models\JobPosting;

class PostingsController
{
    public function index()
    {
        $listings = Cache::remember('jobs.postings', 60, function () {
            return JobPosting::query()
                ->where('status', JobPosting::STATUS_OPEN)
                ->get(['id', 'title']);
        });

        return response()->json(['listings' => $listings]);
    }
}
