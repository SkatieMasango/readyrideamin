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
        Schema::create('operators', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('user_name')->unique();
            // $table->string('password')->default('admin');
            // $table->unsignedBigInteger('mobile_number')->unique()->nullable();
            // $table->json('enabled_notifications')->nullable(); // Will store enum array
            // $table->string('email')->nullable();
            // $table->string('address')->nullable();
            // $table->unsignedBigInteger('media_id')->nullable();
            // $table->unsignedBigInteger('role_id')->nullable();
            // $table->unsignedBigInteger('fleet_id')->nullable();
            // $table->softDeletes();
            // $table->timestamps();

            // // Foreign keys
            // $table->foreign('media_id')->references('id')->on('media')->onDelete('set null');
            // $table->foreign('role_id')->references('id')->on('operator_roles')->onDelete('set null');
            // $table->foreign('fleet_id')->references('id')->on('fleets')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('operators');
    }
};
