<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TrackingCode extends Model
{
    /*
     |--------------------------------------------------------------------------
     | Traits:
     |--------------------------------------------------------------------------
    */
    use HasFactory;

    /*
     |--------------------------------------------------------------------------
     | Variables:
     |--------------------------------------------------------------------------
    */
    protected $guarded = ["id"];

    public const FLASHCARD_CORRECT_ANSWER_STATUS = "Correct";
    public const FLASHCARD_IN_CORRECT_ANSWER_STATUS = "In correct";
    public const FLASHCARD_NOT_ANSWERED_STATUS = "Not Answered";

    public const FLASHCARD_ANSWER_STATUSES = [
        self::FLASHCARD_CORRECT_ANSWER_STATUS,
        self::FLASHCARD_IN_CORRECT_ANSWER_STATUS,
        self::FLASHCARD_NOT_ANSWERED_STATUS,
    ];

    /*
     |--------------------------------------------------------------------------
     | Relations:
     |--------------------------------------------------------------------------
    */
    public function flashCards(): HasMany
    {
        return $this->hasMany(FlashCard::class);
    }
}
