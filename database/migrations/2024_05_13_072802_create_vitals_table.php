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
        Schema::create('vitals', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('provider_id');
            $table->foreign('provider_id')->references('id')->on('users')->onDelete('CASCADE');
            $table->unsignedBigInteger('patient_id');
            $table->foreign('patient_id')->references('id')->on('patients')->onDelete('CASCADE');
            $table->date('date')->nullable();
            $table->string('weight_lbs')->nullable();
            $table->string('weight_oz')->nullable();
            $table->string('weight_kg')->nullable();
            $table->string('height_ft')->nullable();
            $table->string('height_in')->nullable();
            $table->string('height_cm')->nullable();
            $table->string('bmi_kg')->nullable();
            $table->string('bmi_in')->nullable();
            $table->string('bsa_cm2')->nullable();
            $table->string('waist_cm')->nullable();
            $table->string('systolic')->nullable();
            $table->string('diastolic')->nullable();
            $table->string('position')->nullable();
            $table->string('cuff_size')->nullable();
            $table->string('cuff_location')->nullable();
            $table->string('cuff_time')->nullable();
            $table->string('fasting')->nullable();
            $table->string('postprandial')->nullable();
            $table->string('blood_pressure')->nullable();
            $table->string('fasting_blood_sugar')->nullable();
            $table->string('blood_sugar_time')->nullable();
            $table->string('pulse_result')->nullable();
            $table->string('pulse_rhythm')->nullable();
            $table->string('pulse_time')->nullable();
            $table->string('body_temp_result_f')->nullable();
            $table->string('body_temp_result_c')->nullable();
            $table->string('body_temp_method')->nullable();
            $table->string('body_temp_time')->nullable();
            $table->string('respiration_result')->nullable();
            $table->string('respiration_pattern')->nullable();
            $table->string('respiration_time')->nullable();
            $table->string('saturation')->nullable();
            $table->string('oxygenation_method')->nullable();
            $table->string('device')->nullable();
            $table->string('oxygen_source_1')->nullable();
            $table->string('oxygenation_time_1')->nullable();
            $table->string('inhaled_o2_concentration')->nullable();
            $table->string('oxygen_flow')->nullable();
            $table->string('oxygen_source_2')->nullable();
            $table->string('oxygenation_time_2')->nullable();
            $table->string('peak_flow')->nullable();
            $table->string('oxygenation_time_3')->nullable();
            $table->string('office_test_blood_group')->nullable();
            $table->dateTime('blood_group_date')->nullable();
            $table->string('office_test_pain_scale')->nullable();
            $table->dateTime('pain_scale_date')->nullable();
            $table->string('glucose')->nullable();
            $table->string('waist_in')->nullable();
            $table->string('head_in')->nullable();
            $table->string('resp_rate')->nullable();
            $table->string('pulse_beats_in')->nullable();
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
