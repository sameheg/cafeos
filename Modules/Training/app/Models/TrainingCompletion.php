<?php

namespace Modules\Training\Models;

use App\Models\Concerns\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TrainingCompletion extends Model
{
    use BelongsToTenant, HasFactory;

    protected $fillable = [
        'tenant_id',
        'user_id',
        'training_material_id',
        'completed_at',
        'expires_at',
        'certified',
    ];

    protected $casts = [
        'completed_at' => 'datetime',
        'expires_at' => 'datetime',
        'certified' => 'boolean',
    ];

    public function material(): BelongsTo
    {
        return $this->belongsTo(TrainingMaterial::class, 'training_material_id');
    }
}
