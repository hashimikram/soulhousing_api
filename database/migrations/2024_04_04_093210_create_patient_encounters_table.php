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
        Schema::create('patient_encounters', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('provider_id');
            $table->foreign('provider_id')->references('id')->on('users')->onDelete('CASCADE');
            $table->unsignedBigInteger('patient_id');
            $table->foreign('patient_id')->references('id')->on('patients')->onDelete('CASCADE');
            $table->unsignedBigInteger('signed_by');
            $table->foreign('signed_by')->references('id')->on('users')->onDelete('CASCADE');
            $table->string('encounter_date');
            $table->unsignedBigInteger('encounter_type')->nullable();
            $table->foreign('encounter_type')->references('id')->on('list_options')->onDelete('CASCADE');
            $table->unsignedBigInteger('specialty')->nullable();
            $table->foreign('specialty')->references('id')->on('list_options')->onDelete('CASCADE');
            $table->unsignedBigInteger('parent_encounter')->nullable();
            $table->foreign('parent_encounter')->references('id')->on('patient_encounters')->onDelete('CASCADE');
            $table->string('location')->nullable();
            $table->longText('reason');
            $table->longText('attachment')->nullable();
            $table->enum('status', ['1', '0'])->default('1');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patient_encounters');
    }
};
