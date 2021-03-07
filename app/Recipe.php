<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\PathologyRecipe;

class Recipe extends Model
{
    public function pathologies()
    {
        $pathologies = PathologyRecipe::select(
            'pathologies.*',
            'pathology_recipes.allowed')
        ->join('pathologies', 'pathologies.id', '=', 'pathology_recipes.pathology_id')
        ->where('recipe_id', $this->id)
        ->get();

        return $pathologies;
    }
}
