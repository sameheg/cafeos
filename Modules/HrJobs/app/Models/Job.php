<?php

namespace Modules\HrJobs\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Concerns\BelongsToTenant;

class Job extends Model
{
    use BelongsToTenant;

    protected $fillable = [
        'tenant_id',
        'title',
        'description',
        'status',
    ];

    public function applications(): HasMany
    {
        return $this->hasMany(Application::class);
    }
}
