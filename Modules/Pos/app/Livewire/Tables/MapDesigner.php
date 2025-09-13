<?php

namespace Modules\Pos\Livewire\Tables;

use Livewire\Component;
use Modules\Pos\Entities\TableLayout;

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
