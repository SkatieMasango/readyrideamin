<?php

use App\Models\Coupon;
use App\Models\Driver;
use App\Models\Rider;
use App\Models\Service;
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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Rider::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Driver::class)->nullable()->constrained()->nullOnDelete();
            $table->foreignIdFor(Service::class)->nullable();
            $table->foreignIdFor(Coupon::class)->nullable();

            $table->string('status');
            $table->integer('distance_best');
            $table->integer('duration_best');
            $table->integer('wait_minutes')->default(0);
            $table->decimal('wait_cost', 10, 2)->nullable();
            $table->decimal('service_options_cost', 10, 2)->nullable();
            $table->decimal('tax_cost', 10, 2)->nullable();
            $table->decimal('service_cost', 10, 2)->nullable();
            $table->json('points')->nullable();
            $table->json('addresses')->nullable();
            $table->timestamp('expected_timestamp')->nullable();
            $table->timestamp('driver_last_seen_messages_at')->nullable();
            $table->timestamp('rider_last_seen_messages_at')->nullable();
            $table->integer('destination_arrived_to')->nullable();
            $table->timestamp('start_timestamp')->nullable();
            $table->timestamp('finish_timestamp')->nullable();
            $table->decimal('cost_after_coupon', 10, 2)->nullable();
            $table->string('payment_mode')->nullable();

            $table->timestamp('pickup_at')->nullable();
            $table->boolean('payment_status')->default(false);

            // $table->string('payment_status')->nullable();
            $table->decimal('cost_best', 10, 2)->nullable();
            $table->decimal('paid_amount', 10, 2)->nullable();
            $table->decimal('tip_amount', 10, 2)->nullable();
            $table->decimal('provider_share', 10, 2)->nullable();
            $table->string('currency', 10)->nullable();
            $table->json('directions')->nullable();
            $table->json('driver_directions')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
