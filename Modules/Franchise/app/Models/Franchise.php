<?php

namespace Modules\Franchise\Models;

use App\Models\TenantModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Translatable\HasTranslations;

class Franchise extends TenantModel
{
    use HasFactory, HasTranslations;

    protected array $translatable = ['name', 'description'];

    protected $fillable = [
        'tenant_id',
        'user_id',
        'name',
        'description',
        'fee',
    ];
}
