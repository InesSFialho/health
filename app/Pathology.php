<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pathology extends Model
{
    function not_allowed_recipes()
    {
        $recipes = Pathology::select('recipes.*')
        ->join('pathology_recipes', 'recipes.id', '=', 'pathology_recipes.recipe_id')
        ->join('recipes', 'recipes.id', '=', 'pathology_recipes.recipe_id')
        ->where('pathology_recipes.allowed', 1)
        ->where('pathology_users.have', 0)
        ->where('pathology_users.user_id', $this->id)
        ->whereNULL('pathology_recipes.deleted_at')
        ->whereNULL('recipes.deleted_at')
        ->distinct()
        ->get();

        return $recipes;
    }
}
