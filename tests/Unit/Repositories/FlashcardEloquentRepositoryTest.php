<?php

namespace Tests\Unit\Repositories;

use App\Models\Flashcard;
use App\Repositories\Contracts\FlashcardRepositoryInterface;
use App\Repositories\Contracts\TrackingCodeRepositoryInterface;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class FlashcardEloquentRepositoryTest extends TestCase
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
     * Check if all returns an array
     *
     * @return void
     */
    public function test_all_method_returns_an_array(): void
    {
        $flashcards = $this->getFlashcardRepository()->all(
            [], true
        );

        $this->assertIsArray($flashcards);
    }

    /**
     * Check if total returns an int
     *
     * @return void
     */
    public function test_total_method_return_integer(): void
    {
        $total = $this->getFlashcardRepository()->total();

        $this->assertIsInt($total);
    }

    /**
     * Check if totalPerTrackingCode returns an int
     *
     * @return void
     */
    public function test_total_per_tracking_code_method_return_integer(): void
    {
        $trackingCode = $this->getTrackingCodeRepository()->store();

        $total = $this->getFlashcardRepository()->totalPerTrackingCode($trackingCode);

        $this->assertIsInt($total);
    }

    /**
     * Check if totalPerTrackingCode with conditions returns an int
     *
     * @return void
     */
    public function test_total_per_tracking_code_method_with_conditions_return_integer(): void
    {
        $trackingCode = $this->getTrackingCodeRepository()->store();

        $conditions = [
            "column" => "flashcard_tracking_code.status",
            "value" => Flashcard::STATUS_CORRECT_ANSWER
        ];

        $total = $this->getFlashcardRepository()->totalPerTrackingCode($trackingCode, $conditions);

        $this->assertIsInt($total);
    }

    /**
     * Check if store actually stores and question equals the stored question
     *
     * @return void
     */
    public function test_store_method_stores_and_last_stored_item_exists(): void
    {
        $this->getFlashcardRepository()->store(
            [
                "question" => $question = "2 + 2",
                "answer" => "4"
            ]
        );

        $flashcards = $this->getFlashcardRepository()->all(
            [
                "question"
            ], false
        );

        $this->assertEquals($question, $flashcards->first()->question);
    }

    /**
     * Check if reset clears user progress and returns zero flashcards
     *
     * @return void
     */
    public function test_reset_method_clears_progress(): void
    {
        $trackingCode = $this->getTrackingCodeRepository()->store();

        $this->getFlashcardRepository()->store(
            [
                "question" => "2 + 2",
                "answer" => "4"
            ]
        );

        $trackingCode->flashcards()->attach([1]);

        $this->getFlashcardRepository()->reset($trackingCode);

        $this->assertEquals(0, $trackingCode->flashcards()->count());
    }

    /**
     * Check if setNewStatusForFlashcard method changing status properly
     *
     * @return void
     */
    public function test_set_new_status_for_flashcard_method_working(): void
    {
        $trackingCode = $this->getTrackingCodeRepository()->store();

        $this->getFlashcardRepository()->store(
            [
                "question" => "2 + 2",
                "answer" => "4"
            ]
        );

        $flashcard = $this->getFlashcardRepository()->all()->last();

        $this->getFlashcardRepository()->setNewStatusForFlashcard($trackingCode, $flashcard, Flashcard::STATUS_INCORRECT_ANSWER);


        $this->assertEquals(
            Flashcard::STATUS_INCORRECT_ANSWER,
            $trackingCode->flashcards()->where("id", $flashcard->id)->get(["flashcard_tracking_code.status"])->first()->status
        );

    }

    /*
     |--------------------------------------------------------------------------
     | Helper Functions:
     |--------------------------------------------------------------------------
    */
    public function getFlashcardRepository(): FlashcardRepositoryInterface
    {
        return app(FlashcardRepositoryInterface::class);
    }

    public function getTrackingCodeRepository(): TrackingCodeRepositoryInterface
    {
        return app(TrackingCodeRepositoryInterface::class);
    }
}
