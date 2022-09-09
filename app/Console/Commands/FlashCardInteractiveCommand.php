<?php

namespace App\Console\Commands;

use App\Models\Flashcard;
use App\Models\TrackingCode;
use App\Repositories\Contracts\FlashcardRepositoryInterface;
use App\Repositories\Contracts\TrackingCodeRepositoryInterface;
use Illuminate\Console\Command;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use JetBrains\PhpStorm\NoReturn;

class FlashcardInteractiveCommand extends Command
{
    /*
     |--------------------------------------------------------------------------
     | Variables:
     |--------------------------------------------------------------------------
    */
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'flashcard:interactive';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command will bring the menu for students to practice';

    /**
     * The current tracking_code
     *
     * @var TrackingCode
     */
    private TrackingCode $trackingCode;

    /*
     |--------------------------------------------------------------------------
     | General Functions:
     |--------------------------------------------------------------------------
    */

    public function __construct(
        public FlashcardRepositoryInterface $flashcardRepository,
        public TrackingCodeRepositoryInterface $trackingCodeRepository
    )
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle(): void
    {

        $this->showWelcome();

        $this->handleUserSignInChoice(
            $this->askForTrackingCode()
        );

    }

    private function showWelcome(): void
    {
        $this->newLine();
        $this->line("**********************************************************");
        $this->line("*****           <fg=yellow;options=bold>" . trans("studocu.header") . "</>               *****");
        $this->line("**********************************************************");
        $this->newLine();
        $this->line(trans("studocu.description"));
    }

    /*
     |--------------------------------------------------------------------------
     | Sign in functions :
     |--------------------------------------------------------------------------
    */

    private function askForTrackingCode(): int
    {
        return array_search(
            $this->choice(
                trans("studocu.sign_in_ask_text"),
                $choices = [
                    1 => trans("studocu.sign_in_no_answer"),
                    2 => trans("studocu.sign_in_yes_answer"),
                ]
            ),
            $choices
        );
    }

    private function handleUserSignInChoice($signInChoice)
    {
        match ($signInChoice) {
            1 => $this->startFresh(),
            2 => $this->continueWithTrackingCode(),
        };
    }

    private function startFresh()
    {
        $this->createTrackingCode();

        $this->handleUserChoice(
            $this->showInteractiveMenu()
        );
    }

    private function continueWithTrackingCode()
    {
        $this->findTheTrackingCode();

        $this->handleUserChoice(
            $this->showInteractiveMenu()
        );
    }

    /*
     |--------------------------------------------------------------------------
     | Menu Functions:
     |--------------------------------------------------------------------------
    */

    private function showInteractiveMenu(): int
    {
        $this->createMenuTitle(trans("studocu.menu_0"));

        $this->info(trans("studocu.menu_tracking_code") . $this->trackingCode->tracking_code);

        return array_search(
            $this->choice(
                trans("studocu.menu_text"),
                $choices = [
                    1 => trans("studocu.menu_1"),
                    2 => trans("studocu.menu_2"),
                    3 => trans("studocu.menu_3"),
                    4 => trans("studocu.menu_4"),
                    5 => trans("studocu.menu_5"),
                    6 => trans("studocu.menu_6"),
                ]
            ),
            $choices
        );
    }

    private function handleUserChoice(int $choice)
    {
        match ($choice) {
            1 => $this->createFlashcard(),
            2 => $this->listAllFlashcards(),
            3 => $this->practice(),
            4 => $this->stats(),
            5 => $this->reset(),
            6 => $this->exit(),
        };
    }

    private function createFlashcard()
    {
        $this->createMenuTitle(trans("studocu.menu_1"));

        $flashcard = [];

        $flashcard["question"] = $this->ask(trans("studocu.create_flashcard_question"));

        $flashcard["answer"] = $this->ask(trans("studocu.create_flashcard_answer"));

        $this->flashcardRepository->store($flashcard);

        $this->returnToMenu();
    }

    private function listAllFlashcards()
    {
        $this->createMenuTitle(trans("studocu.menu_2"));

        $flashcards = $this->flashcardRepository->all(
            [
                "reference_code", "question", "answer"
            ],
            true
        );

        $this->newLine();

        foreach ($flashcards as $k => $flashcard) {
            $this->line(++$k .")");
            $this->line(trans("studocu.list_all_flashcards_question_label") . "<question>" . $flashcard["question"] . "</question>");
            $this->line(trans("studocu.list_all_flashcards_answer_label") . "<info>" . $flashcard["answer"] . "</info>");
            $this->line(trans("studocu.list_all_flashcards_reference_code_label") . "<error>" .$flashcard["reference_code"] . "</error>");
            $this->newLine(2);
        }

        $this->returnToMenu();

    }

    private function practice()
    {
        $this->createMenuTitle(trans("studocu.menu_3"));

        $this->showPracticeTable();

        $this->showQuestion();

    }

    private function stats()
    {
        $this->createMenuTitle(trans("studocu.menu_4"));

        $total = $this
            ->flashcardRepository
            ->total();

        $totalPerTrackingCode = $this
            ->flashcardRepository
            ->totalPerTrackingCode($this->trackingCode);

        $totalPerTrackingCodeCorrect = $this
            ->flashcardRepository
            ->totalPerTrackingCode(
                $this->trackingCode,
                [
                    "column" => "flashcard_tracking_code.status",
                    "value" => Flashcard::STATUS_CORRECT_ANSWER
                ]
            );

        $this->table(
            [
                trans("studocu.stats_total_questions"),
                trans("studocu.stats_answered_questions"),
                trans("studocu.stats_correct_answers"),
            ],
            [
                [
                    $total,
                    round(($totalPerTrackingCode / $total) * 100, 2) . "%",
                    round(($totalPerTrackingCodeCorrect / $total) * 100, 2) . "%",
                ]
            ],
            "box"
        );

        $this->returnToMenu();
    }

    private function reset()
    {
        $this->createMenuTitle(trans("studocu.menu_5"));

        $this->flashcardRepository->reset($this->trackingCode);

        $this->info(trans("studocu.reset_text"));

        $this->newLine();

        $this->returnToMenu();
    }

    #[NoReturn] private function exit()
    {
        $this->createMenuTitle(trans("studocu.menu_6"));

        $this->newLine();

        exit(0);
    }

    /*
     |--------------------------------------------------------------------------
     | Helper functions:
     |--------------------------------------------------------------------------
    */

    private function createMenuTitle($string)
    {
        $this->line("<bg=blue;options=bold> " . $string . " </>");
    }

    private function returnToMenu()
    {
        $this->handleUserChoice(
            $this->showInteractiveMenu()
        );
    }

    private function createTrackingCode()
    {
        $this->trackingCode = $this->trackingCodeRepository->store();
    }

    private function findTheTrackingCode()
    {
        $trackingCode = $this->ask(
            trans("studocu.sign_in_ask_tracking_code")
        );

        $this->trackingCode = $this->trackingCodeRepository->findTrackingCode($trackingCode);

    }

    private function showPracticeTable()
    {

        $flashcards = $this->flashcardRepository->getFlashcardsPerTrackingCodeWithStatus($this->trackingCode);

        $this->table(
            [
                trans("studocu.practice_reference_code_label"),
                trans("studocu.practice_question_label"),
                trans("studocu.practice_status_label"),
            ],
            $flashcards,
            "box"
        );

        $percentage = $this->flashcardRepository->getProgressPercentage($flashcards);

        $this->info(" Your progress is " . $percentage . "% ");

        $this->newLine();
    }

    private function showQuestion()
    {
        $referenceCode = $this->ask(trans("studocu.practice_ask_reference_code"));

        if(empty($referenceCode)){

            $this->returnToMenu();

        }

        $flashcard = $this->flashcardRepository->getFlashcardByReferenceCode($referenceCode);

        if (empty($flashcard)) {

            $this->error(trans("studocu.practice_validation_not_found"));

            $this->showQuestion();

        }

        if($this->flashcardRepository->checkIfFlashcardAnsweredCorrectly($this->trackingCode, $flashcard->reference_code)){

            $this->error(trans("studocu.practice_validation_already_answered"));

            $this->showQuestion();
        }

        $answer = $this->ask("<question>" . $flashcard->question . "</question>");

        $this->flashcardRepository->setNewStatusForFlashcard($this->trackingCode, $flashcard, $answer);

        $this->practice();

    }

}
