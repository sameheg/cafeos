<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MfgRecipe extends Model
{
    protected $guarded = ['id'];

    public function ingredients()
    {
        return $this->hasMany(MfgRecipeIngredient::class);
    }
}

