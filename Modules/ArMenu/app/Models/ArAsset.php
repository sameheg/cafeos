<?php

namespace Modules\ArMenu\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Support\Facades\Event;
use Modules\ArMenu\Events\ArMenuViewed;

class ArAsset extends Model
{
    use HasUlids;

    protected $table = 'ar_assets';

    protected $fillable = [
        'tenant_id', 'item_id', 'url', 'type', 'state'
    ];

    protected $casts = [
        'state' => 'string',
    ];

    public function markViewed(string $mode = 'ar'): void
    {
        $this->state = 'viewed';
        $this->save();
        Event::dispatch(new ArMenuViewed($this->item_id, $mode));
    }

    public function markAdded(): void
    {
        $this->state = 'added';
        $this->save();
    }

    public function markFallback(): void
    {
        $this->state = 'fallback';
        $this->save();
    }
}
