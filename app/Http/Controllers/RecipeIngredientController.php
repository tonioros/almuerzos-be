<?php

namespace App\Http\Controllers;

use App\Models\RecipeIngredient;
use Illuminate\Http\Request;

class RecipeIngredientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $recipe_id = $request->get("recipe_id");
        $ingredient = $request->get("ingredient");
        $orderBy = $request->get("orderBy");
        $limit = $request->get("limit");
        $recipeList = RecipeIngredient::query();
        if ($recipe_id) {
            $recipeList->where('recipe_id', $recipe_id);
        }
        if ($ingredient) {
            $recipeList->where('ingredient', $ingredient);
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
    public function show(RecipeIngredient $recipeIngredient)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, RecipeIngredient $recipeIngredient)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RecipeIngredient $recipeIngredient)
    {
        //
    }
}
