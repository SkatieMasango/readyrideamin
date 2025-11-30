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
        Schema::create('fleets', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->bigInteger('phone_number');
            $table->string('account_number');
            $table->bigInteger('mobile_number');
            $table->tinyInteger('commission_share_percent')->default(0);
            $table->float('commission_share_flat', 8, 2)->default(0);
            $table->string('address')->nullable();
            $table->string('user_name')->nullable();
            $table->string('password')->nullable();
            $table->float('fee_multiplier', 10, 2)->nullable();
            $table->json('exclusivity_areas')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fleets');
    }
};
