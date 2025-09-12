<?php

namespace Modules\Franchise\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Event;
use Modules\Franchise\Enums\TemplateState;
use Modules\Franchise\Events\TemplateUpdated;

class FranchiseTemplate extends Model
{
    use HasFactory, HasUlids;

    protected $table = 'franchise_templates';

    protected $fillable = [
        'tenant_id',
        'type',
        'data',
        'version',
        'state',
    ];

    protected $casts = [
        'data' => 'array',
        'state' => TemplateState::class,
    ];

    protected $attributes = [
        'version' => 1,
        'state' => TemplateState::Local,
    ];

    public function syncPush(array $changes): void
    {
        $this->data = array_merge($this->data ?? [], $changes);
        $this->version++;
        $this->state = TemplateState::Synced;
        $this->save();

        TemplateUpdated::dispatch($this->getKey(), $changes);
    }

    public function override(array $changes): void
    {
        $this->data = array_merge($this->data ?? [], $changes);
        $this->state = TemplateState::Overridden;
        $this->save();
    }

    public function audit(): void
    {
        $this->state = TemplateState::Audited;
        $this->save();
    }
}
