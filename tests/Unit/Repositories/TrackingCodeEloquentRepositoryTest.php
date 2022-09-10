<?php

namespace Tests\Unit\Repositories;

use App\Repositories\Contracts\TrackingCodeRepositoryInterface;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class TrackingCodeEloquentRepositoryTest extends TestCase
{
    /*
     |--------------------------------------------------------------------------
     | Traits:
     |--------------------------------------------------------------------------
    */
    use DatabaseMigrations;
    /*
     |--------------------------------------------------------------------------
     | Test Functions:
     |--------------------------------------------------------------------------
    */

    /**
     * Check if all method returning collection count is correct
     *
     * @return void
     */
    public function test_all_method_count_of_the_collection_is_correct(): void
    {
        $this->getTrackingCodeRepository()->store();

        $trackingCodes = $this->getTrackingCodeRepository()->all();

        $this->assertEquals(1, $trackingCodes->count());
    }

    /**
     * Check if store actually stores and returns one item
     *
     * @return void
     */
    public function test_store_method_stores_and_last_stored_item_exists(): void
    {
        $trackingCode = $this->getTrackingCodeRepository()->store()->tracking_code;

        $lastTrackingCode = $this->getTrackingCodeRepository()->all()->last()->tracking_code;

        $this->assertEquals($trackingCode, $lastTrackingCode);
    }

    /**
     * Check if find tracking code actually return the right tracking code
     *
     * @return void
     */
    public function test_find_method_tracking_code_returns_tracking_code(): void
    {
        $trackingCode = $this->getTrackingCodeRepository()->store();

        $foundTrackingCode = $this->getTrackingCodeRepository()->findTrackingCode($trackingCode->tracking_code);

        $this->assertEquals($trackingCode->tracking_code, $foundTrackingCode->tracking_code);
    }

    /*
     |--------------------------------------------------------------------------
     | Helper Functions:
     |--------------------------------------------------------------------------
    */

    public function getTrackingCodeRepository(): TrackingCodeRepositoryInterface
    {
        return app(TrackingCodeRepositoryInterface::class);
    }
}
