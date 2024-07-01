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
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('provider_id');
            $table->foreign('provider_id')->references('id')->on('users')->onDelete('Cascade');
            $table->string('mrn_no');
            $table->string('title')->nullable();
            $table->string('first_name')->nullable();
            $table->string('middle_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('social_security_no')->nullable();
            $table->string('medical_no')->nullable();
            $table->string('age')->nullable();
            $table->string('gender')->nullable();
            $table->string('date_of_birth')->nullable();
            $table->text('race')->nullable();
            $table->text('ethnicity')->nullable();
            $table->string('marital_status')->nullable();
            $table->text('referral_source_1')->nullable();
            $table->text('referral_source_2')->nullable();
            $table->text('financial_class')->nullable();
            $table->text('fin_class_name')->nullable();
            $table->text('doctor_name')->nullable();
            $table->string('auth')->nullable();
            $table->string('account_no')->nullable();
            $table->string('admit_date')->nullable();
            $table->string('disch_date')->nullable();
            $table->string('adm_dx')->nullable();
            $table->string('resid_military')->nullable();
            $table->string('pre_admit_date')->nullable();
            $table->string('service')->nullable();
            $table->string('nursing_station')->nullable();
            $table->string('occupation')->nullable();
            $table->string('employer')->nullable();
            $table->string('email')->nullable();
            $table->text('other_contact_name')->nullable();
            $table->text('other_contact_address')->nullable();
            $table->text('other_contact_country')->nullable();
            $table->text('other_contact_city')->nullable();
            $table->text('other_contact_state')->nullable();
            $table->text('other_contact_phone_no')->nullable();
            $table->text('other_contact_cell')->nullable();
            $table->text('relationship')->nullable();
            $table->text('medical_dependency')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('language')->nullable();
            $table->string('phone_no')->nullable();
            $table->string('zip_code')->nullable();
            $table->string('country')->nullable();
            $table->longText('profile_pic')->nullable();
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
