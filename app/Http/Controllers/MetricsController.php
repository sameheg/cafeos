<?php

namespace App\Http\Controllers;

use Prometheus\CollectorRegistry;
use Prometheus\RenderTextFormat;
use Symfony\Component\HttpFoundation\Response;

class MetricsController extends Controller
{
    public function __invoke(): Response
    {
        $renderer = new RenderTextFormat;
        $metrics = $renderer->render(
            CollectorRegistry::getDefault()->getMetricFamilySamples()
        );

        return response($metrics, 200, ['Content-Type' => RenderTextFormat::MIME_TYPE]);
    }
}
