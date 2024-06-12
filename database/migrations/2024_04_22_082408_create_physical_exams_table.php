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
        Schema::create('physical_exams', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('provider_id');
            $table->foreign('provider_id')->references('id')->on('users')->onDelete('CASCADE');
            $table->unsignedBigInteger('patient_id');
            $table->foreign('patient_id')->references('id')->on('patients')->onDelete('CASCADE');
            $table->unsignedBigInteger('encounter_id');
            $table->foreign('encounter_id')->references('id')->on('patient_encounters')->onDelete('CASCADE');
            // $table->string('general_appearance')->default('All Good');
            // $table->string('head_and_neck')->default('All Good');
            // $table->string('eyes')->default('All Good');
            // $table->string('ears')->default('All Good');
            // $table->string('nose')->default('All Good');
            // $table->string('mouth_and_throat')->default('All Good');
            // $table->string('cardiovascular')->default('All Good');
            // $table->string('respiratory_system')->default('All Good');
            // $table->string('abdomen')->default('All Good');
            // $table->string('musculoskeletal_system')->default('All Good');
            // $table->string('neurological_system')->default('All Good');
            // $table->string('genitourinary_system')->default('All Good');
            // $table->string('psychosocial_assessment')->default('All Good');
            $table->string('section_title')->nullable();
            $table->string('section_slug')->nullable();
            $table->longText('section_text')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('physical_exams');
    }
};
