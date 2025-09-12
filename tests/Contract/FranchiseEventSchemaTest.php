<?php

namespace Tests\Contract;

use Modules\Franchise\Events\TemplateUpdated;
use PHPUnit\Framework\TestCase;

class FranchiseEventSchemaTest extends TestCase
{
    public function test_schema_matches_spec(): void
    {
        $event = new TemplateUpdated('707', ['price' => 20]);

        $this->assertSame('franchise.template.updated@v1', $event->broadcastAs());
        $this->assertSame([
            'template_id' => '707',
            'changes' => ['price' => 20],
        ], $event->payload());
    }
}
