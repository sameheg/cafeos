<?php

namespace Modules\FoodSafety\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUlids;

class FoodSafetyLog extends Model
{
    use HasFactory, HasUlids;

    protected $table = 'foodsafety_logs';

    protected $fillable = [
        'tenant_id',
        'item_id',
        'temp',
        'timestamp',
        'status',
    ];

    protected $casts = [
        'temp' => 'encrypted:decimal:2',
        'timestamp' => 'datetime',
    ];

    public function actions()
    {
        return $this->hasMany(FoodSafetyAction::class, 'log_id');
    }
}
