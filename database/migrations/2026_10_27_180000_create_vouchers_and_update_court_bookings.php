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
        // 1. Create vouchers table
        Schema::create('vouchers', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique()->index();
            $table->string('name');
            $table->enum('discount_type', ['fixed', 'percent'])->default('fixed');
            $table->decimal('discount_value', 10, 2);
            $table->decimal('min_spend', 10, 2)->nullable();
            $table->decimal('max_discount', 10, 2)->nullable();
            $table->unsignedInteger('usage_limit')->nullable();
            $table->unsignedInteger('times_used')->default(0);
            $table->unsignedInteger('usage_limit_per_user')->default(1);
            $table->boolean('is_active')->default(true);
            $table->dateTime('starts_at')->nullable();
            $table->dateTime('expires_at')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });

        // 2. Add voucher and discount columns to court_bookings
        Schema::table('court_bookings', function (Blueprint $table) {
            $table->foreignId('voucher_id')->nullable()->after('rentals_fee')->constrained('vouchers')->nullOnDelete();
            $table->string('voucher_code')->nullable()->after('voucher_id');
            $table->decimal('discount_amount', 10, 2)->default(0.00)->after('voucher_code');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('court_bookings', function (Blueprint $table) {
            $table->dropForeign(['voucher_id']);
            $table->dropColumn(['voucher_id', 'voucher_code', 'discount_amount']);
        });

        Schema::dropIfExists('vouchers');
    }
};
