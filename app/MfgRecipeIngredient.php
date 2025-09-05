<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MfgRecipeIngredient extends Model
{
    protected $guarded = ['id'];

    public function recipe()
    {
        return $this->belongsTo(MfgRecipe::class, 'mfg_recipe_id');
    }
}

