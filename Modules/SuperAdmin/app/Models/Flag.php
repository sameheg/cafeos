<?php

namespace Modules\SuperAdmin\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Modules\SuperAdmin\Events\ModuleDisabled;

class Flag extends Model
{
    use HasFactory, HasUlids;

    protected $table = 'superadmin_flags';

    protected $fillable = ['module', 'tenant_id', 'enabled'];

    protected $casts = [
        'enabled' => 'boolean',
    ];

    public function suspend(): void
    {
        $this->update(['enabled' => false]);
        event(new ModuleDisabled($this->module, $this->tenant_id));
    }

    public function restore(): void
    {
        $this->update(['enabled' => true]);
    }

    public function killSwitch(): void
    {
        $this->update(['enabled' => false]);
        event(new ModuleDisabled($this->module, $this->tenant_id));
    }
}
