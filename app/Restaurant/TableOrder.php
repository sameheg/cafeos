<?php

namespace App\Restaurant;

use App\Events\TableOrderPlaced;
use Illuminate\Database\Eloquent\Model;

class TableOrder extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'placed_at' => 'datetime',
    ];

    protected static function booted()
    {
        static::created(function ($order) {
            event(new TableOrderPlaced($order));
        });
    }

    public function table()
    {
        return $this->belongsTo(ResTable::class, 'table_id');
    }

    public function transaction()
    {
        return $this->belongsTo(\App\Transaction::class, 'transaction_id');
    }
}
