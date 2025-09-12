<?php

namespace Modules\SuperAdmin\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\ValidationException;
use Modules\Core\Models\Tenant;
use Modules\SuperAdmin\Events\ModuleDisabled;

class Flag extends Model
{
    use HasFactory, HasUlids;

    protected $table = 'superadmin_flags';

    protected $fillable = ['module', 'tenant_id', 'enabled'];

    protected $casts = [
        'enabled' => 'boolean',
    ];

    protected static function booted(): void
    {
        static::saving(function (Flag $flag) {
            if (! $flag->enabled) {
                return;
            }

            $dependencies = config('module-dependencies.'.$flag->module, []);

            foreach ($dependencies as $dependency) {
                $depFlag = self::query()
                    ->where('module', $dependency)
                    ->where('tenant_id', $flag->tenant_id)
                    ->first();

                if (! $depFlag || ! $depFlag->enabled) {
                    throw ValidationException::withMessages([
                        'module' => sprintf('%s requires %s', $flag->module, $dependency),
                    ]);
                }
            }
        });
    }

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

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
