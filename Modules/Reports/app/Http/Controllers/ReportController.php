<?php

namespace Modules\Reports\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Reports\Services\ReportAggregator;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ReportController
{
    public function __construct(private ReportAggregator $aggregator) {}

    public function index(Request $request)
    {
        $filters = $request->only(['time', 'staff', 'item']);

        return response()->json($this->aggregator->aggregate($filters));
    }

    public function export(Request $request, string $format)
    {
        $data = $this->aggregator->aggregate($request->only(['time', 'staff', 'item']));

        return match ($format) {
            'csv' => $this->toCsv($data),
            'excel' => $this->toExcel($data),
            'pdf' => $this->toPdf($data),
            default => abort(400, 'Unsupported format'),
        };
    }

    protected function toCsv(array $data): StreamedResponse
    {
        $response = new StreamedResponse(function () use ($data) {
            $handle = fopen('php://output', 'w');
            if (! empty($data)) {
                fputcsv($handle, array_keys(reset($data)));
                foreach ($data as $row) {
                    fputcsv($handle, $row);
                }
            }
            fclose($handle);
        });

        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', 'attachment; filename="report.csv"');

        return $response;
    }

    protected function toExcel(array $data): StreamedResponse
    {
        $response = $this->toCsv($data);
        $response->headers->set('Content-Type', 'application/vnd.ms-excel');
        $response->headers->set('Content-Disposition', 'attachment; filename="report.xls"');

        return $response;
    }

    protected function toPdf(array $data): StreamedResponse
    {
        $response = new StreamedResponse(function () use ($data) {
            foreach ($data as $row) {
                echo implode(' | ', $row)."\n";
            }
        });

        $response->headers->set('Content-Type', 'application/pdf');
        $response->headers->set('Content-Disposition', 'attachment; filename="report.pdf"');

        return $response;
    }
}
