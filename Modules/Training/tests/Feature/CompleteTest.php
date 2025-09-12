<?php

namespace Modules\Training\Tests\Feature;

use Modules\Training\Database\Factories\TrainingCourseFactory;
use Tests\TestCase;

class CompleteTest extends TestCase
{
    public function test_progress_update_and_list(): void
    {
        $course = TrainingCourseFactory::new()->create();

        $response = $this->patchJson('/api/v1/training/progress', [
            'tenant_id' => $course->tenant_id,
            'employee_id' => 'emp1',
            'course_id' => $course->id,
            'percent' => 60,
        ]);

        $response->assertOk()->assertJson(['updated' => true]);

        $list = $this->getJson('/api/v1/training/courses/emp1');
        $list->assertOk()->assertJsonStructure(['courses']);
    }
}
