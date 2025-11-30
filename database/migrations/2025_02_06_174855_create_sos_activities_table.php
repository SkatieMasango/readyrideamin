<?php

use App\Enums\SOSActivity;
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
        Schema::create('sos_activities', function (Blueprint $table) {
            $table->id();
            $table->enum('status', SOSActivity::values());
            $table->string('note', 2000)->nullable();
            $table->foreignId('operator_id')->nullable()->constrained('operators')->onDelete('set null');
            $table->foreignId('sos_id')->constrained('sos')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sos_activities');
    }
};
