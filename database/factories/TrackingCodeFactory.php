<?php

namespace Database\Factories;

use App\Models\TrackingCode;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<TrackingCode>
 */
class TrackingCodeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "tracking_code" => fake()->unique()->uuid
        ];
    }
}
