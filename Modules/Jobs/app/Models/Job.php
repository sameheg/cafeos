<?php

namespace Modules\Jobs\Models;

use App\Models\TenantModel;
use Spatie\Translatable\HasTranslations;

class Job extends TenantModel
{
    use HasTranslations;

    /**
     * The attributes that are translatable.
     *
     * @var list<string>
     */
    protected array $translatable = ['description'];

    protected $fillable = ['tenant_id'];
}
