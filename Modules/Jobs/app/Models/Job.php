<?php

namespace Modules\Jobs\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Job extends Model
{
    use HasTranslations;

    /**
     * The attributes that are translatable.
     *
     * @var list<string>
     */
    protected array $translatable = ['description'];
}
