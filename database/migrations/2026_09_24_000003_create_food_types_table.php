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
        Schema::create('food_types', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('food_category_id')->constrained('food_categories')->cascadeOnDelete();
            $table->string('name');
            $table->string('default_risk_category')->default('medium');
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index('default_risk_category');
            $table->index('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('food_types');
    }
};
