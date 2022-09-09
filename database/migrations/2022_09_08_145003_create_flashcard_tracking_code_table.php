<?php

use App\Models\Flashcard;
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
        Schema::create('flashcard_tracking_code', function (Blueprint $table) {
            $table->unsignedBigInteger("tracking_code_id");
            $table->unsignedBigInteger("flashcard_id");
            $table->enum("status", Flashcard::ANSWER_STATUSES);

            $table->primary(
                [
                    "tracking_code_id",
                    "flashcard_id",
                ]
            );

            $table->foreign('flashcard_id')
                ->on('flashcards')
                ->references('id');

            $table->foreign('tracking_code_id')
                ->on('tracking_codes')
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
        Schema::dropIfExists('flashcard_tracking_code');
    }
};
