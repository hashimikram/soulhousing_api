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
        Schema::create('insurances', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('provider_id');
            $table->foreign('provider_id')->references('id')->on('users')->onDelete('Cascade');
            $table->unsignedBigInteger('patient_id');
            $table->foreign('patient_id')->references('id')->on('patients')->onDelete('Cascade');
            $table->string('plan_name');
            $table->string('effective_date');
            $table->string('effective_date_end');
            $table->string('policy_number');
            $table->string('group_number');
            $table->string('subscriber_employee');
            $table->string('se_address');
            $table->string('se_address_2');
            $table->string('se_city');
            $table->string('se_state');
            $table->string('se_zip_code');
            $table->string('se_country');
            $table->string('relationship');
            $table->string('subscriber');
            $table->string('date_of_birth')->nullable();
            $table->string('gender')->nullable();
            $table->string('s_s')->nullable();
            $table->longText('subscriber_address');
            $table->longText('subscriber_address2');
            $table->string('city');
            $table->string('state');
            $table->string('zip_code');
            $table->string('country');
            $table->string('subscriber_phone')->nullable();
            $table->string('co_pay');
            $table->string('accept_assignment');
            $table->longText('secondary_medicare_type')->nullable();
            $table->enum('status',['0','1'])->default('1');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('insurances');
    }
};
