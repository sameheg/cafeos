<?php

namespace Tests\Unit;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\Str;
use Modules\Franchise\Enums\TemplateState;
use Modules\Franchise\Events\TemplateUpdated;
use Modules\Franchise\Models\FranchiseTemplate;
use Tests\TestCase;

class TemplateSyncTest extends TestCase
{
    public function test_push_updates_state_and_version(): void
    {
        Event::fake([TemplateUpdated::class]);

        $template = FranchiseTemplate::create([
            'tenant_id' => (string) Str::uuid(),
            'type' => 'recipe',
            'data' => ['price' => 10],
        ]);

        $template->syncPush(['price' => 20]);

        $this->assertEquals(2, $template->version);
        $this->assertEquals(TemplateState::Synced, $template->state);
        Event::assertDispatched(TemplateUpdated::class);
    }
}
