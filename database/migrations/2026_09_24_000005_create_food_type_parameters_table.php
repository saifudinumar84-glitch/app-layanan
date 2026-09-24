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
        Schema::create('food_type_parameters', function (Blueprint $table) {
            $table->foreignUuid('food_type_id')->constrained('food_types')->cascadeOnDelete();
            $table->foreignUuid('test_parameter_id')->constrained('test_parameters')->cascadeOnDelete();
            $table->timestamps();

            $table->primary(['food_type_id', 'test_parameter_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('food_type_parameters');
    }
};
