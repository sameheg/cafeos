<?php

namespace Modules\SuperAdmin\Livewire;

use Livewire\Component;
use Modules\SuperAdmin\Models\Flag;

class GlobalControlScreen extends Component
{
    public function render()
    {
        return view('superadmin::livewire.global-control-screen', [
            'flags' => Flag::all(),
        ]);
    }
}
