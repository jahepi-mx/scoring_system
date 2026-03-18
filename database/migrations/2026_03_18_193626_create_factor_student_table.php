<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('factor_student', function (Blueprint $table) {
            $table->id();

            // The denormalized evaluation_id for easy bulk deletion
            $table->foreignId('evaluation_id')->constrained()->cascadeOnDelete();

            // Standard pivot foreign keys
            $table->foreignId('factor_id')->constrained()->cascadeOnDelete();
            $table->foreignId('student_id')->constrained()->cascadeOnDelete();

            // The actual score data
            $table->decimal('hits', 8, 2);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('factor_student');
    }
};
