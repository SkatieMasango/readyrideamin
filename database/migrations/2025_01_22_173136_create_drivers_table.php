<?php

use App\Models\User;
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
        Schema::create('drivers', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)
                ->constrained()
                ->cascadeOnDelete();
            $table->string('emergency_contact')->nullable();
            $table->string('driver_licence')->nullable();
            $table->string('nid')->nullable();
            $table->string('vehcle_paper')->nullable();
            $table->string('certificate_number')->nullable();

            $table->foreignId('vehicle_id')->nullable()->constrained('vehicle_models')->nullOnDelete();
            $table->string('vehicle_color_legacy')->nullable();
            $table->foreignId('vehicle_color_id')->nullable()->constrained('vehicle_colors')->nullOnDelete();
            $table->integer('vehicle_production_year')->nullable();
            $table->string('vehicle_plate')->nullable();

            $table->integer('search_distance')->nullable();
            $table->enum('status', ['WaitingDocuments', 'Enabled', 'Disabled'])->default('WaitingDocuments');
            $table->float('rating')->nullable();
            $table->smallInteger('review_count')->default(0);
            $table->string('account_number')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('bank_routing_number')->nullable();
            $table->string('bank_swift')->nullable();
            $table->string('notification_player_id')->nullable();
            $table->string('soft_rejection_note')->nullable();
            $table->integer('preset_avatar_number')->nullable();
            $table->foreignId('fleet_id')->nullable()->constrained('fleets')->nullOnDelete();
            $table->enum('driver_status', ['Online', 'Offline'])->default('Offline');
            $table->string('radius_in_meter')->nullable();
            $table->json('current_location')->nullable();
            $table->decimal('heading', 6, 2)->nullable();
            $table->boolean('on_trip')->default(false);
            $table->string('stripe_customer')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('drivers');
    }
};
