<?php

return [

    /*
    |--------------------------------------------------------------------------
    | StuDocU application texts
    |--------------------------------------------------------------------------
    */

    "header" => "StuDocU Practice Arena",
    "description" => " This is StuDocU interactive learning tool. from the menu \n" .
        " below you can store a flashcard or list all the flash cards \n" .
        " or learn, memorize and practice.",

    /*
     |--------------------------------------------------------------------------
     | Signing In:
     |--------------------------------------------------------------------------
    */
    "sign_in_ask_text" => "Do you have a tracking code?",
    "sign_in_yes_answer" => "Yes, I already practiced before and I have a tracking code.",
    "sign_in_no_answer" => "No, I want to start fresh.",
    "sign_in_ask_tracking_code" => "Enter your tracking code:",
    "sign_in_validation" => "We couldn't find anybody with this tracking code!",

    /*
     |--------------------------------------------------------------------------
     | Menu Options:
     |--------------------------------------------------------------------------
    */
    "menu_text" => "Choose the action you want",
    "menu_tracking_code" => "Your tracking code is: ",
    "menu_0" => "Menu",
    "menu_1" => "Create A Flashcard",
    "menu_2" => "List All Flashcards",
    "menu_3" => "Practice",
    "menu_4" => "Stats",
    "menu_5" => "Reset",
    "menu_6" => "Exit",

    /*
     |--------------------------------------------------------------------------
     | Create a flashcard:
     |--------------------------------------------------------------------------
    */
    "create_flashcard_question" => "Enter the question:",
    "create_flashcard_answer" => "Enter the answer:",

    /*
     |--------------------------------------------------------------------------
     | List all flashcards:
     |--------------------------------------------------------------------------
    */
    "list_all_flashcards_question_label" => "Question: ",
    "list_all_flashcards_answer_label" => "Answer: ",
    "list_all_flashcards_reference_code_label" => "Reference Code: ",

    /*
     |--------------------------------------------------------------------------
     | Practice:
     |--------------------------------------------------------------------------
    */
    "practice_reference_code_label" => "Reference Code",
    "practice_question_label" => "Question",
    "practice_status_label" => "Status",
    "practice_ask_reference_code" =>  "Enter the reference code or press enter to return to menu:",
    "practice_validation_not_found" => "There is not a flashcard with this reference code!",
    "practice_validation_already_answered" => "You already answered this question correctly",

    /*
     |--------------------------------------------------------------------------
     | Stats:
     |--------------------------------------------------------------------------
    */
    "stats_total_questions" => "Total Questions",
    "stats_answered_questions" => "Answered Questions",
    "stats_correct_answers" => "Correct Answers",

    /*
     |--------------------------------------------------------------------------
     | Reset:
     |--------------------------------------------------------------------------
    */
    "reset_text" => "Erased all the progress. You can now start from the beginning!"

];
