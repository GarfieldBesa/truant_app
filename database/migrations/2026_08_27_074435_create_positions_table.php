<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('positions', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->timestamps();
        });

        DB::table('positions')->insert([
            ['name' => 'Secretary', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Part Time', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Production Staff', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Production head', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Jr. Graphic Designer', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Sr. Graphic Designer', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Semi-Skilled', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Labor', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('positions');
    }
};
