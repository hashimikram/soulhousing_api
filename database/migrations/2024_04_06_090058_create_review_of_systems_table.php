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
            $table->unsignedBigInteger('encounter_id');
            $table->foreign('encounter_id')->references('id')->on('patient_encounters')->onDelete('CASCADE');
            // $table->string('constitutional')->default('All Good');
            // $table->string('heent')->default('All Good');
            // $table->string('cv')->default('All Good');
            // $table->string('gi')->default('All Good');
            // $table->string('gu')->default('All Good');
            // $table->string('musculoskeletal')->default('All Good');
            // $table->string('skin')->default('All Good');
            // $table->string('psychiatric')->default('All Good');
            // $table->string('endocrine')->default('All Good');
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
        Schema::dropIfExists('review_of_systems');
    }
};
