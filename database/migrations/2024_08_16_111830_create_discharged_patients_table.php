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
        Schema::create('discharged_patients', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('provider_id')->nullable();
            $table->foreign('provider_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('patient_id')->nullable();
            $table->foreign('patient_id')->references('id')->on('patients')->onDelete('cascade');
            $table->unsignedBigInteger('admission_id')->nullable();
            $table->foreign('admission_id')->references('id')->on('admission_discharges')->onDelete('cascade');
            $table->dateTime('date_of_discharge')->nullable();
            $table->text('acknowledgment_of_discharge')->nullable();
            $table->text('release_of_liability')->nullable();
            $table->text('acknowledgment_of_receipt_of_belongings_and_medication')->nullable();
            $table->text('belongings')->nullable();
            $table->text('medications')->nullable();
            $table->text('patient_signature')->nullable();
            $table->text('staff_witness_signature')->nullable();
            $table->date('patient_signature_date')->nullable();
            $table->date('staff_signature_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('discharged_patients');
    }
};
