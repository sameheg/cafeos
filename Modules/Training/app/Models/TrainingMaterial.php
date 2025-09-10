<?php

namespace Modules\Training\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TrainingMaterial extends Model
{
    use HasFactory;

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
