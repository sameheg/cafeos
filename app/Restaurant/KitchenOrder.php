<?php

namespace App\Restaurant;

use Illuminate\Database\Eloquent\Model;

class KitchenOrder extends Model
{
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    protected $dates = ['started_at', 'completed_at'];

    public function transaction()
    {
        return $this->belongsTo(\App\Transaction::class);
    }

    public function item()
    {
        return $this->belongsTo(\App\TransactionSellLine::class, 'item_id');
    }

    public function location()
    {
        return $this->hasOneThrough(
            \App\BusinessLocation::class,
            \App\Transaction::class,
            'id',
            'id',
            'transaction_id',
            'location_id'
        );
    }
}
