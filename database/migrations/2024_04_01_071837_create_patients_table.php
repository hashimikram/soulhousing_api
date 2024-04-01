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
            $table->string('patient_id');
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name');
            $table->string('nick_name')->nullable();
            $table->string('suffix');
            $table->string('ssn');
            $table->string('gender');
            $table->string('date_of_birth');
            $table->string('general_identity')->nullable();
            $table->string('other')->nullable();
            $table->string('location')->nullable();
            $table->string('pharmacy');
            $table->longText('address_1');
            $table->longText('address_2')->nullable();
            $table->string('city');
            $table->string('state');
            $table->string('suffix_1');
            $table->string('ssn_1');
            $table->string('zip_code');
            $table->string('country');
            $table->enum('status',['0','1'])->default('1');
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
