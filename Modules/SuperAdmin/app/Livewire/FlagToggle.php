<?php

namespace Modules\SuperAdmin\Livewire;

use Livewire\Component;
use Modules\SuperAdmin\Models\Flag;

class FlagToggle extends Component
{
    public string $module;
    public bool $enabled;

    public function mount(string $module, bool $enabled)
    {
        $this->module = $module;
        $this->enabled = $enabled;
    }

    public function updatedEnabled($value): void
    {
        Flag::updateOrCreate(['module' => $this->module, 'tenant_id' => null], ['enabled' => $value]);
    }

    public function render()
    {
        return view('superadmin::livewire.flag-toggle');
    }
}
