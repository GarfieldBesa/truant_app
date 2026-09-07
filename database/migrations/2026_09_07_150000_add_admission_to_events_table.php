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
        Schema::table('events', function (Blueprint $table) {
            if (! Schema::hasColumn('events', 'admission')) {
                $table->string('admission')->default('free')->after('banner');
            }
            if (! Schema::hasColumn('events', 'ticket_price')) {
                $table->string('ticket_price')->nullable()->after('admission');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            $columnsToDrop = [];
            if (Schema::hasColumn('events', 'ticket_price')) {
                $columnsToDrop[] = 'ticket_price';
            }
            if (Schema::hasColumn('events', 'admission')) {
                $columnsToDrop[] = 'admission';
            }
            if (! empty($columnsToDrop)) {
                $table->dropColumn($columnsToDrop);
            }
        });
    }
};
