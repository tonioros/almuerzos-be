<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\Recipe;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Order::factory()
            ->state(new Sequence(
                fn(Sequence $sequence) => ['recipe_id' => Recipe::all()->random()],
            ))->create();
    }
}
