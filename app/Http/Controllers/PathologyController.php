<?php

namespace App\Http\Controllers;

use App\Pathology;
use App\Recipe;
use App\User;
use App\PathologyRecipe;
use App\PathologyUser;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class PathologyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pathologies = Pathology::all();

    	return view('backoffice.pathologies.index', compact('pathologies'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backoffice.pathologies.create');
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
            'name' => 'required|max:255'
        ])->validate();

        $pathology = new Pathology;
        $pathology->name = $request->name;
        $pathology->save();

        $recipes = Recipe::all();
        
        if (!$recipes->isEmpty()) {
            foreach ($recipes as $recipe) {
                $pivot = new PathologyRecipe;
                $pivot->pathology_id = $pathology->id;
                $pivot->recipe_id = $recipe->id;
                $pivot->save();
            }
        }

        $users = User::all();
        
        if (!$users->isEmpty()) {
            foreach ($users as $user) {
                $pivot = new PathologyUser;
                $pivot->pathology_id = $pathology->id;
                $pivot->user_id = $user->id;
                $pivot->save();
            }
        }

        flash(__('Pathology successfully created!'))->success();

        return redirect()->route('pathologies.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Pathology  $pathology
     * @return \Illuminate\Http\Response
     */
    public function show(Pathology $pathology)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Pathology  $pathology
     * @return \Illuminate\Http\Response
     */
    public function edit(Pathology $pathology)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Pathology  $pathology
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pathology $pathology)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Pathology  $pathology
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pathology $pathology)
    {
        //
    }
}
