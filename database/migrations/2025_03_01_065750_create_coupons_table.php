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
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('title');
            $table->text('description')->nullable();
            $table->integer('max_users')->default(0); // 0 means unlimited users can use it
            $table->integer('max_uses_per_user')->default(1); // 1 means each user can use it once
            $table->decimal('minimum_cost', 10, 2)->default(0.00);
            $table->decimal('maximum_cost', 10, 2)->default(0.00);
            $table->timestamp('valid_from');
            $table->timestamp('valid_till')->nullable();
            $table->tinyInteger('discount_percent')->default(0);
            $table->decimal('discount_flat', 10, 2)->default(0.00);
            $table->json('rider_ids')->nullable();
            $table->boolean('is_enabled')->default(true);
            $table->boolean('is_first_travel_only')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};
