<?php

namespace Tests\Feature;

use Tests\TestCase;

class ScriptStackTest extends TestCase
{
    /** @test */
    public function scripts_pushed_to_stack_are_rendered()
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
        $response->assertSee("show_hide_icon').on('click'");
    }
}

