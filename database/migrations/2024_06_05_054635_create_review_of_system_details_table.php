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
        Schema::create('review_of_system_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('provider_id');
            $table->foreign('provider_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('patient_id');
            $table->foreign('patient_id')->references('id')->on('patients')->onDelete('cascade');
            $table->unsignedBigInteger('section_id');
            $table->foreign('section_id')->references('id')->on('encounter_note_sections')->onDelete('cascade');
            $table->text('constitutional')->nullable();
            $table->text('head')->nullable();
            $table->text('neck')->nullable();
            $table->text('eyes')->nullable();
            $table->text('ears')->nullable();
            $table->text('nose')->nullable();
            $table->text('mouth')->nullable();
            $table->text('throat')->nullable();
            $table->text('cardiovascular')->nullable();
            $table->text('respiratory')->nullable();
            $table->text('gastrointestinal')->nullable();
            $table->text('genitourinary')->nullable();
            $table->text('musculoskeletal')->nullable();
            $table->text('endorsis')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('review_of_system_details');
    }
};
