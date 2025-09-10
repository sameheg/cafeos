<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class LangCheckSnapshotTest extends TestCase
{
    public function test_lang_check_output_matches_snapshot(): void
    {
        $output = Artisan::call('lang:check');
        $outputText = Artisan::output();
        $snapshot = __DIR__ . '/../__snapshots__/lang_check.snap';
        if (!file_exists($snapshot)) {
            mkdir(dirname($snapshot), 0777, true);
            file_put_contents($snapshot, $outputText);
        }
        $this->assertSame(trim(file_get_contents($snapshot)), trim($outputText));
        $this->assertSame(0, $output);
    }
}
