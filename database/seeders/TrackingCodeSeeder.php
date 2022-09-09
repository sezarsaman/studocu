<?php

namespace Database\Seeders;

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

        TrackingCode::factory()
            ->count(10)
            ->create();

    }

}
