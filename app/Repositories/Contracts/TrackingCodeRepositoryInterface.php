<?php

namespace App\Repositories\Contracts;

use App\Models\TrackingCode;
use Illuminate\Database\Eloquent\Collection;

interface TrackingCodeRepositoryInterface
{

    public function all(): Collection;

    public function store(): TrackingCode;

    public function findTrackingCode(string $trackingCode): TrackingCode;

    public function storeWithFactory(int $count): void;

}
