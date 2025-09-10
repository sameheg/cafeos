<?php

namespace Modules\Marketplace\Models;

use App\Models\TenantModel;
use Spatie\Translatable\HasTranslations;

class Listing extends TenantModel
{
    use HasTranslations;

    protected $fillable = ['tenant_id'];

    /**
     * The attributes that are translatable.
     *
     * @var list<string>
     */
    protected array $translatable = ['description'];
}
