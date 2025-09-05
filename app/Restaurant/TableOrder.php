<?php

namespace App\Restaurant;

use Illuminate\Database\Eloquent\Model;

class TableOrder extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'placed_at' => 'datetime',
    ];

    public function table()
    {
        return $this->belongsTo(ResTable::class, 'table_id');
    }

    public function transaction()
    {
        return $this->belongsTo(\App\Transaction::class, 'transaction_id');
    }
}
