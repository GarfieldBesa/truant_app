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
        Schema::table('court_bookings', function (Blueprint $table) {
            $table->string('verification_passcode', 10)->nullable()->after('verification_token');
            $table->timestamp('passcode_expires_at')->nullable()->after('verification_passcode');
            $table->unsignedTinyInteger('passcode_attempts')->default(0)->after('passcode_expires_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('court_bookings', function (Blueprint $table) {
            $table->dropColumn(['verification_passcode', 'passcode_expires_at', 'passcode_attempts']);
        });
    }
};
