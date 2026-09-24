<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sample_requirements', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('food_type_id')->nullable()->constrained('food_types')->nullOnDelete();
            $table->string('sample_form')->default('solid');
            $table->integer('min_units')->default(1);
            $table->integer('unit_size')->default(1);
            $table->string('unit')->default('g');
            $table->string('sampling_type')->nullable();
            $table->jsonb('special_requirements')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index('sample_form');
            $table->index('sampling_type');
            $table->index('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sample_requirements');
    }
};
