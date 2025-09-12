<?php
namespace Modules\Pos\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['tenant_id','table_id','status','subtotal','discount_total','tax_total','total','paid_at','invoice_id','paid_total','refunded_total','customer_id'];

    protected $casts = [
        'paid_at' => 'datetime',
    ];

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function refunds(): HasMany
    {
        return $this->hasMany(Refund::class);
    }

    public function recalcTotals(): void
    {
        $subtotal = $this->items()->sum('line_total');
        $discount = 0;
        $tax = 0;
        $total = max(0, $subtotal - $discount + $tax);

        $this->subtotal = $subtotal;
        $this->discount_total = $discount;
        $this->tax_total = $tax;
        $this->total = $total;
        $this->save();
    }
}
