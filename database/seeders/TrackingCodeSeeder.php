<?php

namespace Database\Seeders;

use App\Models\FlashCard;
use App\Models\TrackingCode;
use Illuminate\Database\Seeder;

class TrackingCodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {

        $generatedTrackingCodeUuids = $this->generateTrackingCodeUuids(30);

        foreach ($generatedTrackingCodeUuids as $uuid){

            foreach (FlashCard::all() as $flashCard) {

                TrackingCode::query()
                    ->create(
                        [
                            "tracking_code" => $uuid,
                            "flashcard_id" => $flashCard->id,
                            "status" => fake()->randomElement(
                                TrackingCode::FLASHCARD_ANSWER_STATUSES
                            )
                        ]
                    );

            }

        }

    }

    private function generateTrackingCodeUuids(int $count): array
    {
        for ($i = 0; $i < $count; $i++) {

            $generatedTrackingCodeUuids[] = fake()->unique()->uuid;
        }

        return $generatedTrackingCodeUuids ?? [];
    }

}
