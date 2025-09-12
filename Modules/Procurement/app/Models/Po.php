<?php

namespace Modules\Procurement\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Procurement\Events\PoCreated;

class Po extends Model
{
    use HasFactory, HasUlids;

    protected $table = 'procurement_pos';

    protected $fillable = [
        'tenant_id',
        'bid_id',
        'amount',
        'status',
    ];

    protected $casts = [
        'status' => PoStatus::class,
    ];

    protected static function booted(): void
    {
        static::created(function (self $po) {
            PoCreated::dispatch($po);
        });
    }

    public function bid()
    {
        return $this->belongsTo(Bid::class);
    }

    public function send(): void
    {
        if ($this->status !== PoStatus::Draft) {
            return;
        }
        $this->update(['status' => PoStatus::Sent]);
    }

    public function receive(): void
    {
        if ($this->status !== PoStatus::Sent) {
            return;
        }
        $this->update(['status' => PoStatus::Received]);
    }

    public function match(): void
    {
        if ($this->status !== PoStatus::Received) {
            return;
        }
        $this->update(['status' => PoStatus::Matched]);
    }

    public function cancel(): void
    {
        if ($this->status !== PoStatus::Sent) {
            return;
        }
        $this->update(['status' => PoStatus::Cancelled]);
    }

    public function varianceDetect(): void
    {
        if ($this->status !== PoStatus::Received) {
            return;
        }
        $this->update(['status' => PoStatus::Varied]);
    }
}

enum PoStatus: string
{
    case Draft = 'draft';
    case Sent = 'sent';
    case Received = 'received';
    case Matched = 'matched';
    case Cancelled = 'cancelled';
    case Varied = 'varied';
}
