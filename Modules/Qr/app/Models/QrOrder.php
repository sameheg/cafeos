<?php

namespace Modules\Qr\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class QrOrder extends Model
{
    use HasFactory;

    public const STATUS_PLACED = 'placed';
    public const STATUS_PAID = 'paid';

    protected $fillable = ['tenant_id','qr_id','status','total'];
    public $incrementing = false;
    protected $keyType = 'string';

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (! $model->id) {
                $model->id = (string) Str::ulid();
            }
        });
    }

    public function qrCode()
    {
        return $this->belongsTo(QrCode::class, 'qr_id');
    }
}
