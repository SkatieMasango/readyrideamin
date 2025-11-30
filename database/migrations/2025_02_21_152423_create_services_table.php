<?php

use App\Models\ServiceCategory;
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
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(ServiceCategory::class)->constrained('service_categories')->cascadeOnDelete();
            $table->string('name');
            $table->text('description')->nullable();
            $table->smallInteger('person_capacity')->nullable();
            $table->decimal('base_fare', 12, 2)->default(0.00);
            $table->decimal('per_hundred_meters', 12, 2)->default(0.00);
            $table->decimal('per_minute_drive', 12, 2)->default(0.00);
            $table->decimal('per_minute_wait', 12, 2)->default(0.00);
            $table->decimal('minimum_fee', 10, 2)->default(0.00);
            $table->boolean('two_way_available')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
