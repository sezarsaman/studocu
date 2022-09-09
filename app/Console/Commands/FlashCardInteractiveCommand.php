<?php

namespace App\Console\Commands;

use App\Models\Flashcard;
use App\Models\TrackingCode;
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

        $flashcard["reference_code"] = Str::random(6);

        Flashcard::create($flashcard);

        $this->returnToMenu();
    }

    private function listAllFlashcards()
    {
        $this->createMenuTitle(trans("studocu.menu_2"));

        $flashcards = Flashcard::all(
            [
                "reference_code", "question", "answer"
            ]
        )->toArray();

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

        $this->table(
            [
                trans("studocu.stats_total_questions"),
                trans("studocu.stats_answered_questions"),
                trans("studocu.stats_correct_answers"),
            ],
            [
                [
                    Flashcard::count(),
                    round(($this->trackingCode->flashcards()->count() / Flashcard::count()) * 100, 2) . "%",
                    round(($this->trackingCode->flashcards()->where("flashcard_tracking_code.status", Flashcard::STATUS_CORRECT_ANSWER)->count() / Flashcard::count()) * 100, 2) . "%",
                ]
            ],
            "box"
        );

        $this->returnToMenu();
    }

    private function reset()
    {
        $this->createMenuTitle(trans("studocu.menu_5"));

        $this->trackingCode->flashcards()->sync([]);

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
        $trackingCode = TrackingCode::create(
            [
                "tracking_code" => Str::uuid()
            ]
        );

        $this->trackingCode = $trackingCode;
    }

    private function findTheTrackingCode()
    {
        $trackingCode = $this->ask(
            trans("studocu.sign_in_ask_tracking_code")
        );

        $this->trackingCode = TrackingCode::where("tracking_code", $trackingCode)->first();

    }

    private function showPracticeTable()
    {
        $answeredFlashcards = [];

        $this
            ->trackingCode
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

        $flashcards = Flashcard::get()
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

        $this->table(
            [
                trans("studocu.practice_reference_code_label"),
                trans("studocu.practice_question_label"),
                trans("studocu.practice_status_label"),
            ],
            $flashcards,
            "box"
        );

        $flashcardsTotal = count($flashcards);
        $corrects = array_count_values(data_get($flashcards, "*.status"))[Flashcard::STATUS_CORRECT_ANSWER] ?? 0;
        $percentage = round(($corrects / $flashcardsTotal) * 100, 2);
        $this->info(" Your progress is " . $percentage . "% ");
        $this->newLine();
    }

    private function showQuestion()
    {
        $referenceCode = $this->ask(trans("studocu.practice_ask_reference_code"));

        if(empty($referenceCode)){

            $this->returnToMenu();

        }

        $flashcard = Flashcard::where("reference_code", $referenceCode)->first();

        if (empty($flashcard)) {

            $this->error(trans("studocu.practice_validation_not_found"));

            $this->showQuestion();

        }

        if($this->trackingCode->flashcards()->where("reference_code", $flashcard->reference_code)->count() !== 0){

            if($this->trackingCode->flashcards()->where("reference_code", $flashcard->reference_code)->get(["flashcard_tracking_code.status"])->first()->status == Flashcard::STATUS_CORRECT_ANSWER){

                $this->error(trans("studocu.practice_validation_already_answered"));

                $this->showQuestion();

            }else{

                $this->trackingCode->flashcards()->detach([$flashcard->id]);

            }

        }

        $answer = $this->ask("<question>" . $flashcard->question . "</question>");

        $this->trackingCode->flashcards()->attach(
            [
                $flashcard->id => [
                    "status" => ($answer == $flashcard->answer) ? Flashcard::STATUS_CORRECT_ANSWER : Flashcard::STATUS_INCORRECT_ANSWER
                ]
            ]
        );



        $this->practice();

    }

}
