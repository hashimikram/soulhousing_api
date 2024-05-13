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
        Schema::create('vitals', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('provider_id');
            $table->foreign('provider_id')->references('id')->on('users')->onDelete('CASCADE');
            $table->unsignedBigInteger('patient_id');
            $table->foreign('patient_id')->references('id')->on('patients')->onDelete('CASCADE');
            $table->string('vital_type')->nullable();
            $table->string('blood_sugar')->nullable();
            $table->time('time')->nullable();
            $table->string('pulse_result')->nullable();
            $table->string('pulse_rhythm')->nullable();
            $table->time('pulse_time')->nullable();
            $table->string('body_temperature_result_f')->nullable();
            $table->string('body_temperature_result_c')->nullable();
            $table->string('body_temperature_method');
            $table->time('body_temperature_time')->nullable();
            $table->string('respiration_result')->nullable();
            $table->string('respiration_pattern')->nullable();
            $table->string('respiration_time')->nullable();
            $table->string('oxygenation_saturation')->nullable();
            $table->string('oxygenation_method')->nullable();
            $table->string('oxygenation_device')->nullable();
            $table->string('oxygenation_oxygen_source')->nullable();
            $table->time('oxygenation_time')->nullable();
            $table->string('oxygenation_inhaled_02_concentration')->nullable();
            $table->string('oxygenation_oxygen_flow')->nullable();
            $table->time('oxygenation_time_2')->nullable();
            $table->string('oxygenation_peak_flow')->nullable();
            $table->time('oxygenation_time_3')->nullable();
            $table->string('office_tests')->nullable();
            $table->dateTime('office_tests_date')->nullable();
            $table->unsignedTinyInteger('office_tests_pain_scale')->default(0)->nullable();
            $table->dateTime('office_tests_date_2')->nullable();
            $table->text('office_tests_comments')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vitals');
    }
};
