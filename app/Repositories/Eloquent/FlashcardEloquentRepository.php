<?php

namespace App\Repositories\Eloquent;

use App\Models\Flashcard;
use App\Models\TrackingCode;
use App\Repositories\Contracts\FlashcardRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Collection as IlluminateCollection;
use Illuminate\Support\Str;

class FlashcardEloquentRepository implements FlashcardRepositoryInterface
{

    /*
     |--------------------------------------------------------------------------
     | Functions:
     |--------------------------------------------------------------------------
    */
    public function all(array $fields = [], bool $toArray = false): array|Collection
    {
        if (empty($fields)) {
            $all = Flashcard::all();
        } else {
            $all = Flashcard::all($fields);
        }

        if($toArray){
            return $all->toArray();
        }

        return $all;
    }

    public function total(): int
    {
        return Flashcard::count();
    }

    public function totalPerTrackingCode(TrackingCode $trackingCode, array $condition = []): int
    {
        if(empty($condition)){
            return $trackingCode
                ->flashcards()
                ->count();
        }

        return $trackingCode
            ->flashcards()
            ->where(
                $condition["column"],
                $condition["value"]
            )
            ->count();
    }

    public function reset(TrackingCode $trackingCode): void
    {
        $trackingCode->flashcards()->sync([]);
    }

    public function store(array $flashcard): void
    {
        $flashcard["reference_code"] = Str::random(6);

        Flashcard::create($flashcard);
    }

    public function getFlashcardsPerTrackingCodeWithStatus(TrackingCode $trackingCode): IlluminateCollection
    {
        $answeredFlashcards = $this->getAnsweredFlashcardsArray($trackingCode);

        return Flashcard::get()
            ->map(function ($flashcard) use ($answeredFlashcards){

                if(
                    in_array(
                        $flashcard->reference_code,
                        array_keys($answeredFlashcards)
                    )
                ){
                    $status = $answeredFlashcards[$flashcard->reference_code];
                }

                return [
                    "reference_code" => $flashcard->reference_code,
                    "question" => $flashcard->question,
                    "status" => $status ?? Flashcard::STATUS_NOT_ANSWERED
                ];

            });

    }

    public function getFlashcardByReferenceCode(string $referenceCode): Flashcard
    {
        return Flashcard::where("reference_code", $referenceCode)->first();
    }

    public function checkIfFlashcardAnsweredCorrectly(TrackingCode $trackingCode, string $referenceCode): bool
    {
        if(
            $trackingCode->flashcards()->where("reference_code", $referenceCode)->count() !== 0 &&
            $trackingCode->flashcards()->where("reference_code", $referenceCode)->get(["flashcard_tracking_code.status"])->first()->status == Flashcard::STATUS_CORRECT_ANSWER
        ) {
            return true;
        }

        return false;
    }

    public function setNewStatusForFlashcard(TrackingCode $trackingCode, Flashcard $flashcard, string $answer): void
    {
        $trackingCode->flashcards()->detach([$flashcard->id]);

        $trackingCode->flashcards()->attach(
            [
                $flashcard->id => [
                    "status" => ($answer == $flashcard->answer) ? Flashcard::STATUS_CORRECT_ANSWER : Flashcard::STATUS_INCORRECT_ANSWER
                ]
            ]
        );
    }

    public function getProgressPercentage(IlluminateCollection $flashcards): string
    {
        $flashcardsTotal = count($flashcards);

        $corrects = array_count_values(data_get($flashcards, "*.status"))[Flashcard::STATUS_CORRECT_ANSWER] ?? 0;

        return round(($corrects / $flashcardsTotal) * 100, 2);
    }

    /*
     |--------------------------------------------------------------------------
     | Helper functions:
     |--------------------------------------------------------------------------
    */

    private function getAnsweredFlashcardsArray(TrackingCode $trackingCode): array
    {
        $answeredFlashcards = [];

        $trackingCode
            ->flashcards()
            ->get(
                [
                    "reference_code", "flashcard_tracking_code.status"
                ]
            )->map(
                function ($item) use (&$answeredFlashcards) {
                    $answeredFlashcards[$item->reference_code] = $item->status;
                }
            )->toArray();

        return $answeredFlashcards;
    }

}
