<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('factors', function (Blueprint $table) {
            $table->id();
            // Links to evaluations. Cascades so if an evaluation is deleted, its factors are too.
            $table->foreignId('evaluation_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->tinyInteger('excel_column');
            // Decimal is perfect for weights (e.g., 0.60 for 60%).
            // '4,2' means 4 total digits, 2 after the decimal point (e.g., 99.99).
            $table->decimal('percentage', 4, 2);
            $table->decimal('total_hits', 8, 2);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('factors');
    }
};
