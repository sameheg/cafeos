<?php

namespace Modules\HrJobs\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\HrJobs\Models\Job;

class JobController extends Controller
{
    public function index()
    {
        return Job::with('applications')->get();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string',
            'description' => 'nullable|string',
        ]);

        $data['tenant_id'] = $request->user()->tenant_id ?? null;
        $data['status'] = 'open';

        return Job::create($data);
    }

    public function show(Job $job)
    {
        return $job->load('applications');
    }
}
