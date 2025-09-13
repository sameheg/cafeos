<?php

namespace Modules\Pos\Livewire\Tables;

use Livewire\Component;
use Modules\Pos\Entities\TableLayout;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class MapDesigner extends Component
{
    use AuthorizesRequests;

    public TableLayout $layout;

    public array $layoutData = [];

    public bool $canUpdate = false;

    public function mount(TableLayout $layout): void
    {
        $this->authorize('view', $layout);

        $this->layout = $layout;
        $this->layoutData = $layout->layout ?? [];
        $this->canUpdate = auth()->user()?->can('update', $layout) ?? false;
    }

    public function save(): void
    {
        $this->authorize('update', $this->layout);

        $validated = $this->validate([
            'layoutData' => 'array|max:1000',
            'layoutData.*.x' => 'numeric',
            'layoutData.*.y' => 'numeric',
            'layoutData.*.status' => 'in:available,occupied,selected',
        ]);

        $this->layout->layout = $validated['layoutData'];

class MapDesigner extends Component
{
    public TableLayout $layout;

    public $layoutData = [];

    public function mount(TableLayout $layout)
    {
        $this->layout = $layout;
        $this->layoutData = $layout->layout ?? [];
    }

    public function save()
    {
        $this->layout->layout = $this->layoutData;
        $this->layout->save();
    }

    public function render()
    {
        return view('pos::livewire.tables.map-designer');
    }
}
