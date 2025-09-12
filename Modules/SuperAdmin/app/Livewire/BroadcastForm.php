<?php

namespace Modules\SuperAdmin\Livewire;

use Livewire\Component;
use Modules\SuperAdmin\Jobs\BroadcastMessageJob;

class BroadcastForm extends Component
{
    public string $message = '';

    public function send(): void
    {
        $this->validate(['message' => 'required|string']);
        BroadcastMessageJob::dispatch($this->message);
        $this->reset('message');
    }

    public function render()
    {
        return view('superadmin::livewire.broadcast-form');
    }
}
