<?php

namespace Database\Seeders;

use App\Repositories\Contracts\TrackingCodeRepositoryInterface;
use Illuminate\Database\Seeder;

class TrackingCodeSeeder extends Seeder
{
    /*
     |--------------------------------------------------------------------------
     | Functions:
     |--------------------------------------------------------------------------
    */
    public function __construct(
        public TrackingCodeRepositoryInterface $trackingCodeRepository
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

        $this->trackingCodeRepository->storeWithFactory(10);

    }

}
