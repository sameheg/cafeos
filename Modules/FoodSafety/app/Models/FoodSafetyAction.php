<?php

namespace Modules\FoodSafety\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUlids;

class FoodSafetyAction extends Model
{
    use HasFactory, HasUlids;

    protected $table = 'foodsafety_actions';

    protected $fillable = [
        'tenant_id',
        'log_id',
        'action',
    ];

    public function log()
    {
        return $this->belongsTo(FoodSafetyLog::class, 'log_id');
    }
}
