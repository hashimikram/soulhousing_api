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
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('provider_id');
            $table->foreign('provider_id')->references('id')->on('users')->onDelete('Cascade');
            $table->string('mrn_no')->nullable();
            $table->string('title')->nullable();
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name');
            $table->string('email')->nullable();
            $table->string('phone_no');
            $table->string('nick_name')->nullable();
            $table->string('medical_no')->nullable();
            $table->longText('medical_dependency')->nullable();
            $table->string('ssn');
            $table->string('gender')->nullable();
            $table->string('date_of_birth');
            $table->string('general_identity')->nullable();
            $table->string('other')->nullable();
            $table->string('location')->nullable();
            $table->string('pharmacy')->nullable();
            $table->longText('address_1');
            $table->longText('address_2')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('country')->nullable();
            $table->string('zip_code')->nullable();
            $table->enum('status', ['0', '1'])->default('1');
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
