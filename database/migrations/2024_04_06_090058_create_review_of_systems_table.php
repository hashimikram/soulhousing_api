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
        Schema::create('review_of_systems', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('provider_id');
            $table->foreign('provider_id')->references('id')->on('users')->onDelete('CASCADE');
            $table->unsignedBigInteger('patient_id');
            $table->foreign('patient_id')->references('id')->on('patients')->onDelete('CASCADE');
            $table->string('constitutional')->default('All Good');
            $table->string('heent')->default('All Good');
            $table->string('cv')->default('All Good');
            $table->string('gi')->default('All Good');
            $table->string('gu')->default('All Good');
            $table->string('musculoskeletal')->default('All Good');
            $table->string('skin')->default('All Good');
            $table->string('psychiatric')->default('All Good');
            $table->string('endocrine')->default('All Good');
            $table->string('physical_exam')->default('All Good');
            $table->string('general_appearance')->default('All Good');
            $table->string('head_and_neck')->default('All Good');
            $table->string('eyes')->default('All Good');
            $table->string('ears')->default('All Good');
            $table->string('nose')->default('All Good');
            $table->string('mouth_and_throat')->default('All Good');
            $table->string('cardiovascular')->default('All Good');
            $table->string('respiratory_system')->default('All Good');
            $table->string('abdomen')->default('All Good');
            $table->string('musculoskeletal_system')->default('All Good');
            $table->string('neurological_system')->default('All Good');
            $table->string('genitourinary_system')->default('All Good');
            $table->string('psychosocial_assessment')->default('All Good');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('review_of_systems');
    }
};
