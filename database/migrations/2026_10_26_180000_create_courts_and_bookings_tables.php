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
        // 1. Courts Table
        Schema::create('courts', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('court_type'); // 'pickleball', 'basketball'
            $table->text('description')->nullable();
            $table->unsignedInteger('default_slots_per_hour')->default(4);
            $table->decimal('hourly_rate', 10, 2)->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // 2. Court Unavailabilities (Blackouts per day and per hour)
        Schema::create('court_unavailabilities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('court_id')->constrained()->cascadeOnDelete();
            $table->date('date');
            $table->unsignedTinyInteger('hour')->nullable(); // 0 to 23 (null = full day)
            $table->string('reason')->nullable();
            $table->timestamps();

            $table->unique(['court_id', 'date', 'hour'], 'court_date_hour_unique');
        });

        // 3. Court Bookings Table
        Schema::create('court_bookings', function (Blueprint $table) {
            $table->id();
            $table->string('reference_code')->unique();
            $table->foreignId('court_id')->constrained()->cascadeOnDelete();
            $table->date('booking_date');
            $table->unsignedTinyInteger('start_hour'); // 0 to 23
            $table->unsignedTinyInteger('end_hour');   // 1 to 24
            $table->unsignedInteger('slots_count')->default(1);
            $table->string('customer_name');
            $table->string('customer_email');
            $table->string('customer_contact');
            $table->text('notes')->nullable();
            $table->string('verification_token', 64)->nullable()->unique();
            $table->timestamp('verified_at')->nullable();
            $table->string('payment_mode')->nullable(); // 'cash_on_site', 'gcash', 'bank_transfer'
            $table->text('payment_notes')->nullable();
            $table->string('status')->default('pending_verification'); // pending_verification, verified, confirmed, declined, cancelled
            $table->text('decline_reason')->nullable();
            $table->text('admin_notes')->nullable();
            $table->timestamps();

            $table->index(['court_id', 'booking_date', 'start_hour', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('court_bookings');
        Schema::dropIfExists('court_unavailabilities');
        Schema::dropIfExists('courts');
    }
};
