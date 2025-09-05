<?php

namespace Tests\Feature;

use Tests\TestCase;
use Symfony\Component\Process\Process;

class AccessibilityTest extends TestCase
{
    /** @test */
    public function home_page_generates_axe_report()
    {
        $response = $this->get('/');
        $response->assertStatus(200);

        $file = storage_path('framework/axe-home.html');
        file_put_contents($file, $response->getContent());

        $process = new Process(['npx', 'axe', $file, '--exit', '0', '--json']);
        $process->run();

        $output = $process->getOutput();
        @unlink($file);

        $data = json_decode($output, true);
        $this->assertIsArray($data, 'axe report was not generated');
    }
}
