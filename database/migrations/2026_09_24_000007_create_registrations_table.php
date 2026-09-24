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
        Schema::create('registrations', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('registration_number')->unique();
            $table->foreignUuid('client_id')->constrained('clients')->cascadeOnDelete();
            $table->string('sampling_type')->nullable();
            $table->string('fee_category')->default('paid_service');
            $table->string('status')->default('pending');
            $table->jsonb('form_data')->nullable();
            $table->foreignUuid('confirmed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestampTz('confirmed_at')->nullable();
            $table->text('officer_notes')->nullable();
            $table->date('registration_date');
            $table->timestampsTz();

            $table->index('status');
            $table->index('fee_category');
            $table->index('sampling_type');
            $table->index('registration_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registrations');
    }
};
