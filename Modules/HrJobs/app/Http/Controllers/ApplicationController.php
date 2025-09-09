<?php

namespace Modules\HrJobs\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\HrJobs\Models\Application;
use Modules\HrJobs\Models\Job;

class ApplicationController extends Controller
{
    public function store(Request $request, Job $job)
    {
        $data = $request->validate([
            'member_profile_id' => 'required|exists:member_profiles,id',
            'resume' => 'nullable|string',
        ]);
        $data['job_id'] = $job->id;
        $data['status'] = 'submitted';

        return Application::create($data);
    }

    public function update(Request $request, Application $application)
    {
        $data = $request->validate([
            'status' => 'required|string',
        ]);
        $application->update($data);
        return $application;
    }

    public function show(Application $application)
    {
        return $application->load(['job', 'memberProfile']);
    }
}
