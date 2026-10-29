<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Create Rental Items Table
        Schema::create('rental_items', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('picture')->nullable();
            $table->text('description')->nullable();
            $table->decimal('rental_price', 10, 2)->default(0.00);
            $table->unsignedInteger('total_stock')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // 2. Add Booking Fee & Terms Agreement Columns to court_bookings
        Schema::table('court_bookings', function (Blueprint $table) {
            $table->decimal('court_fee', 10, 2)->default(0.00)->after('slots_count');
            $table->decimal('rentals_fee', 10, 2)->default(0.00)->after('court_fee');
            $table->decimal('total_amount', 10, 2)->default(0.00)->after('rentals_fee');
            $table->boolean('terms_agreed')->default(false)->after('total_amount');
        });

        // 3. Create Court Booking Rentals Pivot / Line-items Table
        Schema::create('court_booking_rentals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('court_booking_id')->constrained('court_bookings')->cascadeOnDelete();
            $table->foreignId('rental_item_id')->constrained('rental_items')->cascadeOnDelete();
            $table->unsignedInteger('quantity')->default(1);
            $table->decimal('unit_price', 10, 2)->default(0.00);
            $table->decimal('subtotal', 10, 2)->default(0.00);
            $table->timestamps();
        });

        // 4. Ensure only Pickle ball court is active by default in existing database
        try {
            DB::table('courts')->where('court_type', '!=', 'pickleball')->update(['is_active' => false]);
            DB::table('courts')->where('slug', 'pickleball-court')->update([
                'name' => 'Pickle ball court',
                'is_active' => true,
            ]);
        } catch (\Throwable $e) {
            // Silently ignore during migration testing
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('court_booking_rentals');

        Schema::table('court_bookings', function (Blueprint $table) {
            $table->dropColumn(['court_fee', 'rentals_fee', 'total_amount', 'terms_agreed']);
        });

        Schema::dropIfExists('rental_items');
    }
};
