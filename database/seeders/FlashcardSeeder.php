<?php

namespace Database\Seeders;

use App\Repositories\Contracts\FlashcardRepositoryInterface;
use Illuminate\Database\Seeder;

class FlashcardSeeder extends Seeder
{
    /*
     |--------------------------------------------------------------------------
     | Functions:
     |--------------------------------------------------------------------------
    */
    public function __construct(
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

        $this->flashcardRepository->storeWithFactory(10);

    }
}
