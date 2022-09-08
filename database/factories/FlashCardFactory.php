<?php

namespace Database\Factories;

use App\Models\FlashCard;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<FlashCard>
 */
class FlashCardFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "question" => fake()->realTextBetween(50,250),
            "answer" => fake()->realTextBetween(50, 250)
        ];
    }
}
