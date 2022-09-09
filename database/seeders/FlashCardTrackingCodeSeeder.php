<?php

namespace Database\Seeders;

use App\Models\Flashcard;
use App\Models\TrackingCode;
use Illuminate\Database\Seeder;

class FlashCardTrackingCodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $trackingCodes = TrackingCode::all();

        $flashcards = [];

        Flashcard::inRandomOrder()
            ->take(fake()->randomDigit())
            ->get()
            ->map(function ($flashcard) use (&$flashcards){
                $flashcards[$flashcard->id] = [
                    "status" => fake()->randomElement(Flashcard::ANSWER_STATUSES)
                ];
            });

        foreach ($trackingCodes as $trackingCode){

            $trackingCode
                ->flashcards()
                ->sync($flashcards);

        }

    }
}
