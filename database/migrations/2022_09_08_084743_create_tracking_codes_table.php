<?php

use App\Models\TrackingCode;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('tracking_codes', function (Blueprint $table) {
            $table->bigIncrements("id");
            $table->string("tracking_code");
            $table->unsignedBigInteger("flashcard_id");
            $table->enum("status", TrackingCode::FLASHCARD_ANSWER_STATUSES);
            $table->timestamps();

            $table->unique(
                [
                    "tracking_code",
                    "flashcard_id"
                ]
            );

            $table->foreign('flashcard_id')
                ->on('flash_cards')
                ->references('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('tracking_codes');
    }
};
