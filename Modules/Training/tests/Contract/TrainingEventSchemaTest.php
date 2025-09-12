<?php

namespace Modules\Training\Tests\Contract;

use Modules\Training\Events\CourseCompleted;
use PHPUnit\Framework\TestCase;

class TrainingEventSchemaTest extends TestCase
{
    public function test_schema(): void
    {
        $event = new CourseCompleted('1010', 'emp2');
        $this->assertSame([
            'course_id' => '1010',
            'employee_id' => 'emp2',
        ], $event->payload());
    }
}
