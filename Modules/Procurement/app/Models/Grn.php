<?php

namespace Modules\Procurement\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grn extends Model
{
    use HasFactory, HasUlids;

    protected $table = 'procurement_grns';

    protected $fillable = [
        'tenant_id',
        'po_id',
        'received_qty',
    ];

    public function po()
    {
        return $this->belongsTo(Po::class);
    }
}
