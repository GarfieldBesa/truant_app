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
        // 1. Update users table for customer roles & Google authentication
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->default('customer')->after('email');
            $table->string('google_id')->nullable()->index()->after('role');
            $table->string('avatar')->nullable()->after('google_id');
            $table->string('phone_number')->nullable()->after('avatar');
            $table->string('password')->nullable()->change();
        });

        // Ensure any pre-existing users are marked as admin so they can access Filament
        try {
            DB::table('users')->update(['role' => 'admin']);
        } catch (\Throwable $e) {
            // Ignore during fresh testing
        }

        // 2. Link court_bookings to users table
        Schema::table('court_bookings', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable()->after('id')->constrained('users')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('court_bookings', function (Blueprint $table) {
            $table->dropConstrainedForeignId('user_id');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'google_id', 'avatar', 'phone_number']);
        });
    }
};
