<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('samples', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('sample_number')->unique();
            $table->foreignUuid('registration_id')->constrained('registrations')->cascadeOnDelete();
            $table->foreignUuid('food_type_id')->constrained('food_types')->restrictOnDelete();
            $table->string('sample_name');
            $table->string('brand')->nullable();
            $table->string('sample_form')->default('solid');
            $table->unsignedInteger('unit_count')->default(1);
            $table->unsignedInteger('unit_size')->default(1);
            $table->string('marketing_authorization')->default('MD');
            $table->string('authorization_number')->nullable();
            $table->string('risk_category')->default('medium');
            $table->decimal('purchase_price', 12, 2)->nullable();
            $table->jsonb('extra_info')->nullable();
            $table->string('status')->default('awaiting_sample');
            $table->string('conclusion')->nullable();
            $table->foreignUuid('received_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestampTz('received_at')->nullable();

            if (DB::getDriverName() === 'pgsql') {
                $table->addColumn('tsvector', 'search_vector')->nullable();
            } else {
                $table->text('search_vector')->nullable();
            }

            $table->timestampsTz();

            $table->index('status');
            $table->index('conclusion');
            $table->index('marketing_authorization');
            $table->index('risk_category');
            $table->index('sample_form');
        });

        if (DB::getDriverName() === 'pgsql') {
            DB::statement('CREATE INDEX IF NOT EXISTS samples_search_vector_idx ON samples USING gin(search_vector)');
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('samples');
    }
};
