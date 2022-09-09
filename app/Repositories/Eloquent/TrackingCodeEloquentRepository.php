<?php

namespace App\Repositories\Eloquent;

use App\Models\TrackingCode;
use App\Repositories\Contracts\TrackingCodeRepositoryInterface;
use Illuminate\Support\Str;

class TrackingCodeEloquentRepository implements TrackingCodeRepositoryInterface
{

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
}
