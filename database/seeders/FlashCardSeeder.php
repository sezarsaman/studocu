<?php

namespace Database\Seeders;

use App\Models\FlashCard;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FlashCardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        FlashCard::factory()
            ->count(10)
            ->create();
    }
}
