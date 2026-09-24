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
        Schema::create('sample_parameters', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('sample_id')->constrained('samples')->cascadeOnDelete();
            $table->foreignUuid('test_parameter_id')->constrained('test_parameters')->restrictOnDelete();
            $table->string('result_value')->nullable();
            $table->string('unit')->nullable();
            $table->string('requirement_limit')->nullable();
            $table->string('compliance_status')->nullable();
            $table->foreignUuid('analyzed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestampTz('tested_at')->nullable();
            $table->timestampsTz();

            $table->index('compliance_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sample_parameters');
    }
};
