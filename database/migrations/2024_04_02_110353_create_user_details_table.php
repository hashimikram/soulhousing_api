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
        Schema::create('user_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            // Personal Details
            $table->string('title')->nullable();
            $table->string('middle_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('suffix')->nullable();
            $table->string('gender')->nullable();
            $table->date('date_of_birth')->nullable();

            // Address Details
            $table->string('street_address')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('zip_code')->nullable();
            $table->string('country')->nullable();

            // Contact Details
            $table->string('home_phone')->nullable();

            // Identification
            $table->string('npi')->nullable();
            $table->string('tax_type')->nullable();
            $table->string('snn')->nullable();
            $table->string('ein')->nullable();
            $table->string('epcs_status')->nullable();
            $table->string('dea_number')->nullable();
            $table->string('nadean')->nullable();
            $table->unsignedBigInteger('speciality_id')->nullable();
            $table->foreign('speciality_id')->references('id')->on('list_options')->onDelete('cascade');

            // Additional Details
            $table->text('facilities')->nullable();
            $table->longText('image')->nullable();

            // Status & Audit Information
            $table->boolean('is_active')->default(true);
            $table->text('notes')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();

            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_details');
    }
};
