<?php

namespace Modules\TableReservations\Models;

use Illuminate\Database\Eloquent\Model;

class Table extends Model
{
    protected $fillable = ['name', 'seats', 'status'];

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}
