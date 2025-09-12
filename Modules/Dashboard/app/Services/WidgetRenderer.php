<?php

namespace Modules\Dashboard\Services;

class WidgetRenderer
{
    public function render(array $widgets): array
    {
        return array_map(fn ($w) => ['widget' => $w, 'html' => "<div>{$w}</div>"], $widgets);
    }
}
