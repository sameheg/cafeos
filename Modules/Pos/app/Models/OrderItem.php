<?php
namespace Modules\Pos\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = ['order_id','sku','name','qty','price','line_total'];

    protected static function booted(): void
    {
        static::saving(function (self $item) {
            $qty = (float)($item->qty ?? 0);
            $price = (float)($item->price ?? 0);
            $item->line_total = $qty * $price;
        });
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
