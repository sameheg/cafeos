<?php

namespace Modules\TableReservations\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $fillable = ['table_id', 'customer_name', 'phone', 'reservation_time', 'status'];

    public function table()
    {
        return $this->belongsTo(Table::class);
    }
}
