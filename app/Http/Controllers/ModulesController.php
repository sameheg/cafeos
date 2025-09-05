<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use App\Models\ModuleStatus;

class ModulesController extends Controller
{
    /**
     * Path to the modules status file.
     *
     * @var string
     */
    protected $path;

    public function __construct()
    {
        $this->path = base_path('modules_statuses.json');
    }

    /**
     * Display all module statuses.
     */
    public function index()
    {
        $modules = $this->read();

        return view('modules.index', compact('modules'));
    }

    /**
     * Toggle the status for the given module and persist the change.
     */
    public function toggle(Request $request, $module)
    {
        $modules = $this->read();
        $modules[$module] = !empty($modules[$module]) ? !$modules[$module] : true;
        $this->write($modules);

        return redirect()->back()->with('status', [
            'success' => true,
            'msg' => __('lang_v1.success'),
        ]);
    }

    /**
     * Read modules status from file.
     */
    protected function read(): array
    {
        if (Schema::hasTable('module_statuses')) {
            return ModuleStatus::pluck('enabled', 'name')->toArray();
        }

        $content = File::exists($this->path) ? File::get($this->path) : '{}';
        $data = json_decode($content, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \RuntimeException('Invalid modules_statuses.json file.');
        }
        return $data;
    }

    /**
     * Write modules status to file and validate result.
     */
    protected function write(array $modules): void
    {
        $json = json_encode($modules, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        if ($json === false) {
            throw new \RuntimeException('Failed to encode module statuses.');
        }
        File::put($this->path, $json . PHP_EOL);
        json_decode($json, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \RuntimeException('Invalid JSON written to modules_statuses.json');
        }

        if (Schema::hasTable('module_statuses')) {
            foreach ($modules as $name => $enabled) {
                ModuleStatus::updateOrCreate(
                    ['name' => $name],
                    ['enabled' => $enabled]
                );
            }
        }
    }
}
