<?php

namespace Modules\Training\Tests\Unit;

use Illuminate\Support\Facades\Event;
use Modules\Training\Events\CourseCompleted;
use Modules\Training\Services\ProgressTracker;
use Modules\Training\Database\Factories\TrainingCourseFactory;
use Tests\TestCase;

class ProgressTrackerTest extends TestCase
{
    public function test_emits_event_when_completed(): void
    {
        Event::fake();
        $course = TrainingCourseFactory::new()->create();
        $tracker = new ProgressTracker();

        $tracker->update($course->tenant_id, 'emp1', $course->id, 100);

        Event::assertDispatched(CourseCompleted::class, function ($event) use ($course) {
            return $event->courseId === $course->id && $event->employeeId === 'emp1';
        });

        $this->assertDatabaseHas('training_progress', [
            'employee_id' => 'emp1',
            'course_id' => $course->id,
            'percent' => 100,
        ]);
    }
}
