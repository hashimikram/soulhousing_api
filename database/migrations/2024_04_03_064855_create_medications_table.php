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
        Schema::create('medications', function (Blueprint $table) {
            $table->id();
            $table->string('favourite_medication');
            $table->unsignedBigInteger('provider_id');
            $table->foreign('provider_id')->references('id')->on('users')->onDelete('CASCADE');
            $table->unsignedBigInteger('patient_id');
            $table->foreign('patient_id')->references('id')->on('patients')->onDelete('CASCADE');
            $table->string('user_free_text')->default('0');
            $table->string('prescribe_date');
            $table->string('action')->nullable();
            $table->string('quantity')->nullable();
            $table->string('dosage_unit')->nullable();
            $table->string('route')->nullable();
            $table->string('frequency')->nullable();
            $table->string('days_supply');
            $table->string('refills');
            $table->string('dispense');
            $table->string('dispense_unit');
            $table->string('primary_diagnosis');
            $table->string('secondary_diagnosis');
            $table->string('substitutions')->default('0');
            $table->string('one_time')->default('0');
            $table->string('prn')->default('0');
            $table->string('administered')->default('0');
            $table->string('prn_options')->nullable();
            $table->longText('patient_directions');
            $table->longText('additional_sig')->nullable();
            $table->enum('status', ['inactive', 'active'])->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medications');
    }
};