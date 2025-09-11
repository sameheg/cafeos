<?php

namespace Modules\Qr\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class QrCode extends Model
{
    use HasFactory;

    protected $fillable = ['tenant_id','table_id','url','generated_at'];
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

    public function orders()
    {
        return $this->hasMany(QrOrder::class, 'qr_id');
    }
}
