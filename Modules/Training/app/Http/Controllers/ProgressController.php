<?php

namespace Modules\Training\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Training\Models\TrainingCourse;
use Modules\Training\Services\ProgressTracker;

class ProgressController extends Controller
{
    public function __construct(private ProgressTracker $tracker)
    {
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'tenant_id' => 'required|string',
            'employee_id' => 'required|string',
            'course_id' => 'required|string',
            'percent' => 'required|integer|min:0|max:100',
        ]);

        $this->tracker->update(
            $data['tenant_id'],
            $data['employee_id'],
            $data['course_id'],
            $data['percent']
        );

        return response()->json(['updated' => true]);
    }

    public function courses(string $employeeId)
    {
        $courses = TrainingCourse::query()
            ->select('training_courses.*')
            ->leftJoin('training_progress', function ($join) use ($employeeId) {
                $join->on('training_courses.id', '=', 'training_progress.course_id')
                    ->where('training_progress.employee_id', '=', $employeeId);
            })
            ->get();

        if ($courses->isEmpty()) {
            return response()->json([], 404);
        }

        return response()->json(['courses' => $courses]);
    }
}
