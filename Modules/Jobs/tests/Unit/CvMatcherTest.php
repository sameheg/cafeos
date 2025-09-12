<?php

namespace Modules\Jobs\Tests\Unit;

use Modules\Jobs\Services\CvMatcher;
use PHPUnit\Framework\TestCase;

class CvMatcherTest extends TestCase
{
    public function test_matcher_scores_keywords(): void
    {
        $matcher = new CvMatcher;
        $score = $matcher->match(['php', 'laravel'], 'Senior PHP developer with Laravel experience');
        $this->assertSame(1.0, $score);
    }
}
