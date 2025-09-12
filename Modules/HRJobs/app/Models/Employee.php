<?php

namespace Modules\HRJobs\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Crypt;

class Employee extends Model
{
    use HasFactory, HasUlids;

    protected $table = 'hr_employees';

    protected $fillable = ['tenant_id', 'name', 'role'];

    protected $casts = [
        'id' => 'string',
    ];

    /**
     * Encrypt the employee name to satisfy privacy requirements.
     */
    public function setNameAttribute(string $value): void
    {
        $this->attributes['name'] = Crypt::encryptString($value);
    }

    public function getNameAttribute(string $value): string
    {
        return Crypt::decryptString($value);
    }

    public function shifts()
    {
        return $this->hasMany(Shift::class);
    }
}

