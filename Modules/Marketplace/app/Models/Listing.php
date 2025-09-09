<?php

namespace Modules\Marketplace\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Listing extends Model
{
    use HasTranslations;

    /**
     * The attributes that are translatable.
     *
     * @var list<string>
     */
    protected array $translatable = ['description'];
}
