<?php

namespace Modules\Jobs\Services;

class CvMatcher
{
    public function match(array $keywords, string $text): float
    {
        $matches = 0;
        foreach ($keywords as $keyword) {
            if (str_contains(strtolower($text), strtolower($keyword))) {
                $matches++;
            }
        }

        return $matches / max(count($keywords), 1);
    }
}
