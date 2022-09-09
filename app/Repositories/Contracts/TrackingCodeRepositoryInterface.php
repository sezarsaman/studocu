<?php

namespace App\Repositories\Contracts;

use App\Models\TrackingCode;

interface TrackingCodeRepositoryInterface
{

    public function store(): TrackingCode;

    public function findTrackingCode(string $trackingCode): TrackingCode;
}
