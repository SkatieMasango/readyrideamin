<?php

use App\Models\Driver;
use App\Models\Order;
use App\Models\Rider;
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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
             $table->foreignIdFor(Order::class)->nullable()->constrained()->nullOnDelete();
            $table->foreignIdFor(Rider::class)->nullable()->constrained()->nullOnDelete();
            $table->foreignIdFor(Driver::class)->nullable()->constrained()->nullOnDelete();
            $table->enum('transaction', ['credit', 'debit'])->nullable();
            $table->double('amount');
            $table->enum('method', ['cash', 'stripe','paystack','razorpay'])->nullable();
            $table->enum('payment_mode', ['received', 'withdraw'])->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
