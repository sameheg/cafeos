<?php

namespace Modules\Pos\Models;

use App\Models\Tenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable as AuditableTrait;
use OwenIt\Auditing\Contracts\Auditable;

class Order extends Model implements Auditable
{
    use HasFactory;
    use SoftDeletes;
    use AuditableTrait;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'tenant_id',
        'total',
        'status',
    ];

    public function tenant(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Tenant::class);
    }

    public function menuItems(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(MenuItem::class);
    }
}
