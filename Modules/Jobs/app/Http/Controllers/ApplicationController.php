<?php

namespace Modules\Jobs\Http\Controllers;

use Illuminate\Http\UploadedFile;
use Modules\Jobs\Http\Requests\ApplicationRequest;
use Modules\Jobs\Models\JobApplication;

class ApplicationController
{
    public function store(ApplicationRequest $request)
    {
        /** @var UploadedFile $cv */
        $cv = $request->file('cv');
        $cvPath = $cv->store('cvs');

        $application = JobApplication::create([
            'tenant_id' => $request->user()?->tenant_id ?? (string) \Illuminate\Support\Str::uuid(),
            'posting_id' => $request->get('job_id'),
            'cv_path' => $cvPath,
            'status' => JobApplication::STATUS_APPLIED,
        ]);

        if (function_exists('feature') && feature('jobs_ai_screen')) {
            // AI screening placeholder
        }

        return response()->json(['app_id' => $application->id], 201);
    }
}
