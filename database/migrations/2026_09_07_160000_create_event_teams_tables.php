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
        Schema::create('event_teams', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained('events')->cascadeOnDelete();
            $table->string('team_name');
            $table->string('team_reference')->unique();
            $table->timestamps();

            $table->unique(['event_id', 'team_name']);
        });

        Schema::create('event_team_members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_team_id')->constrained('event_teams')->cascadeOnDelete();
            $table->foreignId('event_registration_id')->constrained('event_registrations')->cascadeOnDelete();
            $table->string('registration_reference');
            $table->string('member_name');
            $table->timestamps();

            $table->unique(['event_team_id', 'event_registration_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_team_members');
        Schema::dropIfExists('event_teams');
    }
};
