<?php

namespace App\Repositories\Eloquent;

use App\Models\TrackingCode;
use App\Repositories\Contracts\TrackingCodeRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;

class TrackingCodeEloquentRepository implements TrackingCodeRepositoryInterface
{

    /*
     |--------------------------------------------------------------------------
     | Functions:
     |--------------------------------------------------------------------------
    */
    public function all(): Collection
    {
        return TrackingCode::all();
    }

    public function store(): TrackingCode
    {
        return TrackingCode::create(
            [
                "tracking_code" => Str::uuid()
            ]
        );
    }

    public function findTrackingCode(string $trackingCode): TrackingCode
    {
        return TrackingCode::where("tracking_code", $trackingCode)->first();
    }

    public function storeWithFactory(int $count): void
    {
        TrackingCode::factory()
            ->count($count)
            ->create();
    }

}
