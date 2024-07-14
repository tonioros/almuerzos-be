<?php

namespace Database\Factories;

use App\Constants\OrderState;
use App\Models\Recipe;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        return [
            "status" => $this->faker->randomElement([OrderState::PENDING, OrderState::COOKING, OrderState::COMPLETED]),
            "request_date" => $this->faker->dateTime(),
            "delivery_date" => $this->faker->dateTime(),
            "recipe_id" => Recipe::factory()->create()->id,
        ];
    }
}
