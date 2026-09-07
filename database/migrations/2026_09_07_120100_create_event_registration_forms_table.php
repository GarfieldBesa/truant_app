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
        Schema::create('event_registration_forms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->unique()->constrained('events')->cascadeOnDelete();
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->string('consent_title')->default('Consent & Data Privacy Agreement');
            $table->longText('consent_body'); // Required consent form text
            $table->string('consent_checkbox_label')->default('I have read and agree to the consent and terms of registration.');
            $table->json('fields')->nullable(); // Array of dynamic fields
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_registration_forms');
    }
};
