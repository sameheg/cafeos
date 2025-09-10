<?php

namespace Modules\Training\Models;

use App\Models\Concerns\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainingMaterial extends Model
{
    use BelongsToTenant, HasFactory;

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
