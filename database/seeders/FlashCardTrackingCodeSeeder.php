<?php

namespace Database\Seeders;

use App\Repositories\Contracts\FlashcardRepositoryInterface;
use App\Repositories\Contracts\TrackingCodeRepositoryInterface;
use Illuminate\Database\Seeder;

class FlashCardTrackingCodeSeeder extends Seeder
{

    /*
     |--------------------------------------------------------------------------
     | Functions:
     |--------------------------------------------------------------------------
    */
    public function __construct(
        public TrackingCodeRepositoryInterface $trackingCodeRepository,
        public FlashcardRepositoryInterface $flashcardRepository
    )
    {
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {

        $flashcards = $this->flashcardRepository->getRandomFlashCards();

        foreach ($this->trackingCodeRepository->all() as $trackingCode){

            $this
                ->flashcardRepository
                ->syncFlashcardsForTrackingCode($trackingCode, $flashcards);

        }

    }

}
