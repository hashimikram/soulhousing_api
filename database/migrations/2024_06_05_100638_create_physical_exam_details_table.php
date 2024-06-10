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
            $table->text('general_appearance')->nullable();
            $table->text('skin')->nullable();
            $table->text('head')->nullable();
            $table->text('eyes')->nullable();
            $table->text('ears')->nullable();
            $table->text('nose')->nullable();
            $table->text('mouth_throat')->nullable();
            $table->text('neck')->nullable();
            $table->text('chest_lungs')->nullable();
            $table->text('cardiovascular')->nullable();
            $table->text('abdomen')->nullable();
            $table->text('genitourinary')->nullable();
            $table->text('musculoskeletal')->nullable();
            $table->text('neurological')->nullable();
            $table->text('psychiatric')->nullable();
            $table->text('endocrine')->nullable();
            $table->text('hematologic_lymphatic')->nullable();
            $table->text('allergic_immunologic')->nullable();
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
