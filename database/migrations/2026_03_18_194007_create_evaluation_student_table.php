<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('evaluation_student', function (Blueprint $table) {
            $table->id();

            // Link to the evaluation and the student
            $table->foreignId('evaluation_id')->constrained()->cascadeOnDelete();
            $table->foreignId('student_id')->constrained()->cascadeOnDelete();

            // The final calculated score.
            // Using decimal(5,2) allows for scores up to 100.00 (or 999.99 max).
            // Making it nullable is smart here, because when you first import the student,
            // the score hasn't been calculated yet.
            $table->decimal('final_score', 5, 2)->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('evaluation_student');
    }
};
