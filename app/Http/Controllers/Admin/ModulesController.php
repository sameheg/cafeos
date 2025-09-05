<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ModulesController extends Controller
{
    private string $statusFile;

    public function __construct()
    {
        $this->statusFile = base_path('modules_statuses.json');
    }

    public function toggle(Request $request, string $module)
    {
        if (! auth()->user()->can('manage_modules')) {
            abort(403, 'Unauthorized action.');
        }

        $statuses = $this->readStatuses();
        $statuses[$module] = !($statuses[$module] ?? false);
        $this->writeStatuses($statuses);

        return response()->json([
            'module' => $module,
            'enabled' => $statuses[$module],
        ]);
    }

    private function readStatuses(): array
    {
        $raw = file_exists($this->statusFile) ? file_get_contents($this->statusFile) : '{}';
        $data = json_decode($raw, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \RuntimeException('Invalid module status file.');
        }

        return $data;
    }

    private function writeStatuses(array $statuses): void
    {
        // TODO: move module statuses to a dedicated database table to avoid manual file edits.
        $json = json_encode($statuses, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        if ($json === false) {
            throw new \RuntimeException('Unable to encode module statuses.');
        }

        $decoded = json_decode($json, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \RuntimeException('Invalid JSON encoding.');
        }

        file_put_contents($this->statusFile, $json);
    }
}
