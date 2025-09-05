<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ForecastedDemand extends Model
{
    protected $guarded = ['id'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
