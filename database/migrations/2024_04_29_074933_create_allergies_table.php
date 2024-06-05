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
        Schema::create('allergies', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('provider_id');
            $table->foreign('provider_id')->references('id')->on('users')->onDelete('CASCADE');
            $table->unsignedBigInteger('patient_id');
            $table->foreign('patient_id')->references('id')->on('patients')->onDelete('CASCADE');
            $table->unsignedBigInteger('allergy_type');
            $table->foreign('allergy_type')->references('id')->on('list_options')->onDelete('CASCADE');
            $table->unsignedBigInteger('reaction')->nullable();
            $table->foreign('reaction')->references('id')->on('list_options')->onDelete('CASCADE');
            $table->unsignedBigInteger('severity')->nullable();
            $table->foreign('severity')->references('id')->on('list_options')->onDelete('CASCADE');

            $table->string('allergy');
            $table->string('onset_date')->nullable();
            $table->longText('comments')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('allergies');
    }
};
