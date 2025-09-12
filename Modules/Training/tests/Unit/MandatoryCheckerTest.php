<?php

namespace Modules\Training\Tests\Unit;

use Modules\Training\Services\MandatoryChecker;
use Modules\Training\Database\Factories\TrainingCourseFactory;
use Modules\Training\Database\Factories\TrainingProgressFactory;
use Tests\TestCase;

class MandatoryCheckerTest extends TestCase
{
    public function test_checks_compliance(): void
    {
        $tenant = fake()->uuid();
        $course = TrainingCourseFactory::new()->mandatory()->create(['tenant_id' => $tenant]);

        $checker = new MandatoryChecker();
        $this->assertFalse($checker->compliant($tenant, 'emp1'));

        TrainingProgressFactory::new()->create([
            'tenant_id' => $tenant,
            'employee_id' => 'emp1',
            'course_id' => $course->id,
            'percent' => 100,
        ]);

        $this->assertTrue($checker->compliant($tenant, 'emp1'));
    }
}
