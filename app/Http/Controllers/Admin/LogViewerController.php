<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\File;

class LogViewerController extends Controller
{
    public function index()
    {
        $path = storage_path('logs');
        $files = collect(File::files($path))->map(fn($file) => $file->getFilename());

        return view('admin.logs.index', compact('files'));
    }

    public function show(Request $request, $file)
    {
        $file = basename($file);
        $path = storage_path('logs/' . $file);

        if (!File::exists($path)) {
            abort(404);
        }

        if ($request->boolean('download')) {
            return response()->download($path);
        }

        $search = $request->input('q');
        $lines = file($path, FILE_IGNORE_NEW_LINES);

        if ($search) {
            $lines = array_values(array_filter($lines, fn($line) => stripos($line, $search) !== false));
        }

        $perPage = 50;
        $page = LengthAwarePaginator::resolveCurrentPage();
        $items = array_slice($lines, ($page - 1) * $perPage, $perPage);
        $logs = new LengthAwarePaginator($items, count($lines), $perPage, $page, [
            'path' => route('admin.logs.show', $file),
            'query' => $request->query(),
        ]);

        return view('admin.logs.show', [
            'file' => $file,
            'logs' => $logs,
            'query' => $search,
        ]);
    }
}
