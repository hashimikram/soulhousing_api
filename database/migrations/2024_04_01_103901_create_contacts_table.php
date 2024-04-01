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
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('provider_id');
            $table->foreign('provider_id')->references('id')->on('users')->onDelete('Cascade');
            $table->unsignedBigInteger('patient_id');
            $table->foreign('patient_id')->references('id')->on('patients')->onDelete('Cascade');
            $table->string('type');
            $table->string('title')->nullable();
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('date_of_birth')->nullable();
            $table->string('relationship');
            $table->string('email')->nullable();
            $table->longText('address')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('zip_code')->nullable();
            $table->string('country')->nullable();
            $table->longText('home_phone')->nullable();
            $table->longText('work_phone')->nullable();
            $table->string('mobile_number')->nullable();
            $table->string('fax')->nullable();
            $table->string('method_of_contact')->nullable();
            $table->enum('support_contact', ['1', '0'])->default('0');
            $table->string('from_date')->nullable();
            $table->string('to_date')->nullable();
            $table->string('status')->nullable();
            $table->enum('indefinitely', ['1', '0'])->default('0');
            $table->enum('power_of_attorney', ['1', '0'])->default('0');
            $table->string('from_date2')->nullable();
            $table->string('to_date2')->nullable();
            $table->string('status2')->nullable();
            $table->enum('indefinitely2', ['1', '0'])->default('0');
            $table->enum('power_of_attorney2', ['1', '0'])->default('0');
            $table->string('from_date3')->nullable();
            $table->string('to_date3')->nullable();
            $table->string('status3')->nullable();
            $table->enum('indefinitely3', ['1', '0'])->default('0');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contacts');
    }
};
