<?php

use App\Enums\PaymentStatus;
use App\Enums\PayoutType;
use App\Models\Payout;
use App\Models\PayoutGateway;
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
        Schema::create('payouts', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('currency_name')->nullable();
            $table->enum('type', PayoutType::values());
            $table->boolean('payemnt_status')->default(false);
            // $table->enum('payment_status', PaymentStatus::values())->default('in_active');
            $table->string('image')->nullable(); // store image path
            $table->foreignIdFor(PayoutGateway::class)->nullable()->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payouts');
    }
};
