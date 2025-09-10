<?php

namespace Modules\TableReservations\Models;

use App\Models\TenantModel;

class Table extends TenantModel
{
    protected $fillable = ['tenant_id', 'name', 'seats', 'status'];

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}
