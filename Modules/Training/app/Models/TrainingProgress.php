<?php

namespace Modules\Training\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUlids;

class TrainingProgress extends Model
{
    use HasFactory, HasUlids;

    protected $table = 'training_progress';

    protected $fillable = [
        'tenant_id',
        'employee_id',
        'course_id',
        'percent',
    ];

    protected $casts = [
        'percent' => 'integer',
    ];

    public function course()
    {
        return $this->belongsTo(TrainingCourse::class, 'course_id');
    }

    public function state(): string
    {
        if ($this->percent >= 100) {
            return 'Completed';
        }

        if ($this->percent > 0) {
            return 'InProgress';
        }

        return 'Assigned';
    }

    protected static function newFactory()
    {
        return \Modules\Training\Database\Factories\TrainingProgressFactory::new();
    }
}
