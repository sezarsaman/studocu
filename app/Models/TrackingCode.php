<?php

namespace App\Models;

use Database\Factories\TrackingCodeFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;



/**
 * App\Models\TrackingCode
 *
 * @property int $id
 * @property string $tracking_code
 * @property-read Collection|Flashcard[] $flashcards
 * @property-read int|null $flashcards_count
 * @method static TrackingCodeFactory factory(...$parameters)
 * @method static Builder|TrackingCode newModelQuery()
 * @method static Builder|TrackingCode newQuery()
 * @method static Builder|TrackingCode query()
 * @method static Builder|TrackingCode whereId($value)
 * @method static Builder|TrackingCode whereTrackingCode($value)
 * @mixin Eloquent
 */

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

    public $timestamps = false;

    /*
     |--------------------------------------------------------------------------
     | Relations:
     |--------------------------------------------------------------------------
    */
    /**
     * @return BelongsToMany
     */
    public function flashcards(): BelongsToMany
    {
        return $this->belongsToMany(Flashcard::class, "flashcard_tracking_code");
    }
}
