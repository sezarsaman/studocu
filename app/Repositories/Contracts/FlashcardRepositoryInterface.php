<?php

namespace App\Repositories\Contracts;

use App\Models\Flashcard;
use App\Models\TrackingCode;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Collection as IlluminateCollection;

interface FlashcardRepositoryInterface
{

    public function all(array $fields = [], bool $toArray = false): array|Collection;

    public function total(): int;

    public function totalPerTrackingCode(TrackingCode $trackingCode, array $condition = []): int;

    public function store(array $flashcard): void;

    public function reset(TrackingCode $trackingCode): void;

    public function getFlashcardsPerTrackingCodeWithStatus(TrackingCode $trackingCode): IlluminateCollection;

    public function getFlashcardByReferenceCode(string $referenceCode): Flashcard;

    public function checkIfFlashcardAnsweredCorrectly(TrackingCode $trackingCode, string $referenceCode): bool;

    public function setNewStatusForFlashcard(TrackingCode $trackingCode, Flashcard $flashcard, string $answer): void;

    public function getProgressPercentage(IlluminateCollection $flashcards): string;

}
