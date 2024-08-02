<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('wound_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('provider_id');
            $table->foreign('provider_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('patient_id');
            $table->foreign('patient_id')->references('id')->on('patients')->onDelete('cascade');
            $table->string('encounter_id')->nullable();
            $table->unsignedBigInteger('wound_id');
            $table->foreign('wound_id')->references('id')->on('wounds')->onDelete('cascade');
            $table->text('location')->nullable();
            $table->text('width')->nullable();
            $table->text('type')->nullable();
            $table->text('width_cm')->nullable();
            $table->text('length_cm')->nullable();
            $table->text('depth_cm')->nullable();
            $table->text('area_cm')->nullable();
            $table->text('exudate_amount')->nullable();
            $table->text('exudate_type')->nullable();
            $table->text('granulation_tissue')->nullable();
            $table->text('fibrous_tissue')->nullable();
            $table->longText('necrotic_tissue')->nullable();
            $table->text('wound_bed')->nullable();
            $table->text('undermining')->nullable();
            $table->text('tunneling')->nullable();
            $table->text('sinus_tract_cm')->nullable();
            $table->text('exposed_structure')->nullable();
            $table->text('periwound_color')->nullable();
            $table->text('wound_edges')->nullable();
            $table->text('epithelialization')->nullable();
            $table->text('pain_level')->nullable();
            $table->text('infection')->nullable();
            $table->text('wound_duration')->nullable();
            $table->text('clinical_signs_of_infection')->nullable();
            $table->text('status')->nullable();
            $table->text('stage')->nullable();
            $table->longText('images')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wound_details');
    }
};
