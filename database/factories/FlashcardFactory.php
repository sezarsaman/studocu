<?php

namespace Database\Factories;

use App\Models\Flashcard;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Flashcard>
 */
class FlashcardFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $firstDigit = fake()->randomDigit();

        $secondDigit = fake()->randomDigit();

        return [
            "reference_code" => Str::random(6),
            "question" => $firstDigit . " + " . $secondDigit,
            "answer" => $firstDigit + $secondDigit,
        ];
    }
}
