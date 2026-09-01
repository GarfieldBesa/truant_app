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
        Schema::table('positions', function (Blueprint $table) {
            $table->decimal('base_rate', 10, 2)->default(0.00);
            $table->decimal('overtime_rate', 10, 2)->default(0.00);
            $table->decimal('sss', 10, 2)->default(0.00);
            $table->decimal('philhealth', 10, 2)->default(0.00);
            $table->decimal('pag_ibig', 10, 2)->default(0.00);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('positions', function (Blueprint $table) {
            $table->dropColumn(['base_rate', 'overtime_rate', 'sss', 'philhealth', 'pag_ibig']);
        });
    }
};
