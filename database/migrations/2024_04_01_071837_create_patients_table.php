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
            $table->string('other_email')->nullable();
            $table->string('first_name')->nullable();
            $table->string('middle_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('social_security_no')->nullable();
            $table->string('medical_no')->nullable();
            $table->string('age')->nullable();
            $table->string('gender')->nullable();
            $table->string('date_of_birth')->nullable();
            $table->string('referral_source_1')->nullable();
            $table->string('organization')->nullable();
            $table->string('referral_company_name')->nullable();
            $table->string('referral_contact_name')->nullable();
            $table->string('referral_contact_no')->nullable();
            $table->string('referral_contact_email')->nullable();
            $table->text('financial_class')->nullable();
            $table->text('fin_class_name')->nullable();
            $table->text('doctor_name')->nullable();
            $table->string('auth')->nullable();
            $table->string('npp')->nullable();
            $table->string('account_no')->nullable();
            $table->string('admit_date')->nullable();
            $table->string('disch_date')->nullable();
            $table->string('pre_admit_date')->nullable();
            $table->string('nursing_station')->nullable();
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
            $table->text('address')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('primary_language')->nullable();
            $table->string('phone_no')->nullable();
            $table->string('zip_code')->nullable();
            $table->string('country')->nullable();
            $table->longText('profile_pic')->nullable();
            $table->string('speciality_id')->nullable();
            $table->string('facility_id')->nullable();
            $table->string('authorization_no')->nullable();
            $table->string('switch')->default('No');
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