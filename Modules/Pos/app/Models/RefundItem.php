<?php
namespace Modules\Pos\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RefundItem extends Model
{
    use HasFactory;

    protected $fillable = ['refund_id','order_item_id','qty','amount'];

    public function refund(): BelongsTo
    {
        return $this->belongsTo(Refund::class);
    }
}
