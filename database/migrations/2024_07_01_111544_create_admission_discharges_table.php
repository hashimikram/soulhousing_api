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
        Schema::create('admission_discharges', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('provider_id');
            $table->foreign('provider_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('patient_id');
            $table->foreign('patient_id')->references('id')->on('patients')->onDelete('cascade');
            $table->dateTime('admission_date')->nullable();
            $table->text('admission_location')->nullable();
            $table->string('room_no')->nullable();
            $table->string('patient_type')->nullable();
            $table->string('admission_type')->nullable();
            $table->longText('admission_service')->nullable();
            $table->string('new_admission')->nullable();
            $table->string('pan_patient')->nullable();
            $table->text('patient_account_number')->nullable();
            $table->string('discharge_date')->nullable();
            $table->string('new_room')->nullable();
            $table->string('discharge_type')->nullable();
            $table->text('comments')->nullable();
            $table->enum('status', ['0', '1'])->default('1');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admission_discharges');
    }
};
