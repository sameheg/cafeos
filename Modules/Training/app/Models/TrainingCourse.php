<?php

namespace Modules\Training\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUlids;

class TrainingCourse extends Model
{
    use HasFactory, HasUlids;

    protected $table = 'training_courses';

    protected $fillable = [
        'tenant_id',
        'title',
        'mandatory',
    ];

    protected $casts = [
        'mandatory' => 'boolean',
    ];

    protected static function newFactory()
    {
        return \Modules\Training\Database\Factories\TrainingCourseFactory::new();
    }
}
