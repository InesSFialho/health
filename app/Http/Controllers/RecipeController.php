<?php

namespace App\Http\Controllers;

use App\Recipe;
use App\Pathology;
use App\PathologyRecipe;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class RecipeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {        
        $recipes = Recipe::all();

    	return view('backoffice.recipes.index', compact('recipes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backoffice.recipes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:255'
        ])->validate();

        $recipe = new Recipe;
        $recipe->title = $request->title;
        $recipe->save();

        $pathologies = Pathology::all();

        if (!$pathologies->isEmpty()) {
            foreach ($pathologies as $pathology) {
                $pivot = new PathologyRecipe;
                $pivot->pathology_id = $pathology->id;
                $pivot->recipe_id = $recipe->id;
                $pivot->save();
            }
        }

        flash(__('Recipe successfully created!'))->success();

        return redirect()->route('recipes.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Recipe  $recipe
     * @return \Illuminate\Http\Response
     */
    public function show(Recipe $recipe)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Recipe  $recipe
     * @return \Illuminate\Http\Response
     */
    public function edit(Recipe $recipe)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Recipe  $recipe
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Recipe $recipe)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Recipe  $recipe
     * @return \Illuminate\Http\Response
     */
    public function destroy(Recipe $recipe)
    {
        //
    }
    
    public function showRecipePathologies($recipe_id)
    {        
        $recipe = Recipe::find($recipe_id);

    	return view('backoffice.recipes.pathologies', compact('recipe'));
    }

    public function updateRecipePathologies($recipe_id, $pathology_id)
    {        
        $pivot = PathologyRecipe::where('recipe_id', $recipe_id)
        ->where('pathology_id', $pathology_id)
        ->first();

        $pivot->allowed = $pivot->allowed == 0 ? 1 : 0;
        $pivot->save();

        return redirect()->back();
    }


}
