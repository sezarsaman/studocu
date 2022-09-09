<?php

namespace App\Models;

use Database\Factories\FlashcardFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;


/**
 * App\Models\Flashcard
 *
 * @property int $id
 * @property string $question
 * @property string $reference_code
 * @property string $answer
 * @method static FlashcardFactory factory(...$parameters)
 * @method static Builder|Flashcard newModelQuery()
 * @method static Builder|Flashcard newQuery()
 * @method static Builder|Flashcard query()
 * @method static Builder|Flashcard whereAnswer($value)
 * @method static Builder|Flashcard whereId($value)
 * @method static Builder|Flashcard whereQuestion($value)
 * @mixin Eloquent
 */
class Flashcard extends Model
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

    public $timestamps = false;

    public const STATUS_CORRECT_ANSWER = "Correct";
    public const STATUS_INCORRECT_ANSWER = "Incorrect";
    public const STATUS_NOT_ANSWERED = "Not Answered";

    public const ANSWER_STATUSES = [
        self::STATUS_CORRECT_ANSWER,
        self::STATUS_INCORRECT_ANSWER,
    ];

    /*
     |--------------------------------------------------------------------------
     | Relations:
     |--------------------------------------------------------------------------
    */
    /**
     *
     * @return BelongsToMany
     */
    public function trackingCodes(): BelongsToMany
    {
        return $this->belongsToMany(TrackingCode::class, "flashcard_tracking_code");
    }
}
