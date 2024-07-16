<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use Illuminate\Http\Request;

class RecipeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $name = $request->get("name");
        $withIngredientes = $request->get("withIngredientes");
        $orderBy = $request->get("orderBy");
        $limit = $request->get("limit");
        $recipeList = Recipe::query();
        if ($name) {
            $recipeList->where('name', $name);
        }
        if ($withIngredientes) {
            $recipeList->with(['ingredients']);
        }
        if ($limit) {
            $recipeList->limit($limit);
        }
        if ($orderBy) {
            $recipeList->orderBy('id', $orderBy);
        }
        return $recipeList->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Recipe $recipe)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Recipe $recipe)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Recipe $recipe)
    {
        //
    }
}
