<?php

use App\Enums\WithdrawStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Driver;
use App\Models\Order;
use App\Models\Rider;
use App\Models\Transaction;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('withdraws', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Driver::class)->nullable()->constrained()->nullOnDelete();
            $table->foreignIdFor(Transaction::class)->nullable()->constrained()->nullOnDelete();
            $table->double('amount');
            $table->string('method');
            $table->enum('status', WithdrawStatus::values());
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('withdraws');
    }
};
