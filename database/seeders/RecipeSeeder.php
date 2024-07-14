<?php

namespace Database\Seeders;

use App\Models\Recipe;
use App\Models\RecipeIngredient;
use Illuminate\Database\Seeder;

class RecipeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $recipesData = $this->recipes();

        foreach ($recipesData as $recipeData) {
            $recipe = Recipe::factory()->create(['name' => $recipeData['name']]);
            foreach ($recipeData['ingredients'] as $ingredient) {
                RecipeIngredient::factory()
                    ->create(['recipe_id' => $recipe->id, 'ingredient' => $ingredient['ingredient'], 'total_to_use' => $ingredient['total_to_use']]);
            }
        }
    }

    private function recipes()
    {
        return collect([
            ['name' => 'Chicken salad', 'ingredients' =>
                [['ingredient' => 'tomato', 'total_to_use' => 1,], ['ingredient' => 'lemon', 'total_to_use' => 2,], ['ingredient' => 'lettuce', 'total_to_use' => 2,],
                    ['ingredient' => 'onion', 'total_to_use' => 1,], ['ingredient' => 'chicken', 'total_to_use' => 1,],]],
            ['name' => 'French Fries with Meat', 'ingredients' =>
                [['ingredient' => 'potato', 'total_to_use' => 3,], ['ingredient' => 'ketchup', 'total_to_use' => 1,], ['ingredient' => 'onion', 'total_to_use' => 1,],
                    ['ingredient' => 'cheese', 'total_to_use' => 2,], ['ingredient' => 'meat', 'total_to_use' => 1,],]],
            ['name' => 'Rice, Chicken & Vegetables', 'ingredients' =>
                [['ingredient' => 'rice', 'total_to_use' => 1,], ['ingredient' => 'chicken', 'total_to_use' => 1,], ['ingredient' => 'tomato', 'total_to_use' => 3,],
                    ['ingredient' => 'onion', 'total_to_use' => 1,], ['ingredient' => 'potato', 'total_to_use' => 2,],]],
            ['name' => 'Beef Steak Salad', 'ingredients' =>
                [['ingredient' => 'tomato', 'total_to_use' => 1,], ['ingredient' => 'lemon', 'total_to_use' => 2,], ['ingredient' => 'lettuce', 'total_to_use' => 2,],
                    ['ingredient' => 'onion', 'total_to_use' => 1,], ['ingredient' => 'meat', 'total_to_use' => 1,],]],
            ['name' => 'Cheesy chicken bake with new potatoes', 'ingredients' =>
                [['ingredient' => 'chicken', 'total_to_use' => 1,], ['ingredient' => 'potato', 'total_to_use' => 3,], ['ingredient' => 'tomato', 'total_to_use' => 3,],
                    ['ingredient' => 'onion', 'total_to_use' => 2,],]],
            ['name' => 'Grilled chicken & French fries', 'ingredients' =>
                [['ingredient' => 'chicken', 'total_to_use' => 1,], ['ingredient' => 'potato', 'total_to_use' => 3,], ['ingredient' => 'ketchup', 'total_to_use' => 1,],]],
        ]);
    }
}
