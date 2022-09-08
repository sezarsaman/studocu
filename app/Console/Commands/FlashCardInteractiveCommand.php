<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class FlashCardInteractiveCommand extends Command
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
                    1 => trans("studocu.sign_in_yes_answer"),
                    2 => trans("studocu.sign_in_no_answer"),
                ]
            ),
            $choices
        );
    }

    private function handleUserSignInChoice($signInChoice)
    {
        match ($signInChoice) {
            1 => $this->enterTrackingCode(),
            2 => $this->showInteractiveMenu(),
        };
    }

    private function enterTrackingCode()
    {
        $trackingCode = $this->ask(
            trans("studocu.sign_in_ask_tracking_code")
        );

    }

    /*
     |--------------------------------------------------------------------------
     | Menu Functions:
     |--------------------------------------------------------------------------
    */

    private function showInteractiveMenu(): int
    {
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
            1 => $this->createFlashCard(),
            2 => $this->listAllFlashCards(),
            3 => $this->practice(),
            4 => $this->stats(),
            5 => $this->reset(),
            6 => $this->exit(),
        };
    }

    private function createFlashCard()
    {

    }

    private function listAllFlashCards()
    {
    }

    private function practice()
    {
    }

    private function stats()
    {
    }

    private function reset()
    {
    }

    private function exit()
    {
    }

}
