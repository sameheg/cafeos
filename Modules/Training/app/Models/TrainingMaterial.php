<?php

namespace Modules\Training\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Concerns\BelongsToTenant;

class TrainingMaterial extends Model
{
    use HasFactory, BelongsToTenant;

    protected $fillable = [
        'tenant_id',
        'role_id',
        'title',
        'content',
        'quiz',
    ];

    protected $casts = [
        'quiz' => 'array',
    ];
}
