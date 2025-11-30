<?php

use App\Enums\SOSStatus;
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
        Schema::create('sos', function (Blueprint $table) {
            $table->id();
            $table->enum('status', SOSStatus::values())->default(SOSStatus::SUBMITTED);
            $table->json('location')->nullable();
            // TODO update it when create request table
            $table->foreignId('request_id')->nullable()->constrained('orders')->onDelete('cascade');
            $table->boolean('submitted_by_rider');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sos');
    }
};
