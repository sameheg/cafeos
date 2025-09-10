<?php

namespace Modules\TableReservations\Models;

use App\Models\TenantModel;

class Reservation extends TenantModel
{
    protected $fillable = ['tenant_id', 'table_id', 'customer_name', 'phone', 'reservation_time', 'status'];

    public function table()
    {
        return $this->belongsTo(Table::class);
    }
}
