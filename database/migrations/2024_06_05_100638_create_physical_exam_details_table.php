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
        Schema::create('physical_exam_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('provider_id');
            $table->foreign('provider_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('patient_id');
            $table->foreign('patient_id')->references('id')->on('patients')->onDelete('cascade');
            $table->unsignedBigInteger('section_id');
            $table->foreign('section_id')->references('id')->on('encounter_note_sections')->onDelete('cascade');
            $table->text('constitutional')->nullable();
            $table->text('ears_nose_mouth_throat')->nullable();
            $table->text('neck')->nullable();
            $table->text('respiratory')->nullable();
            $table->text('cardiovascular')->nullable();
            $table->text('lungs')->nullable();
            $table->text('chest_breasts')->nullable();
            $table->text('heart')->nullable();
            $table->text('gastrointestinal_abdomen')->nullable();
            $table->text('genitourinary')->nullable();
            $table->text('lymphatic')->nullable();
            $table->text('musculoskeletal')->nullable();
            $table->text('skin')->nullable();
            $table->text('extremities')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('physical_exam_details');
    }
};
