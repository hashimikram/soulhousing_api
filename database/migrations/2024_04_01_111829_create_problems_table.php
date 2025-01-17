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
        Schema::create('problems', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('provider_id');
            $table->foreign('provider_id')->references('id')->on('users')->onDelete('Cascade');
            $table->unsignedBigInteger('patient_id');
            $table->foreign('patient_id')->references('id')->on('patients')->onDelete('Cascade');
            $table->longText('diagnosis')->nullable();
            $table->longText('name')->nullable();
            $table->string('type_id')->nullable();
            $table->string('chronicity_id')->nullable();
            $table->string('severity_id')->nullable();
            $table->string('status_id')->nullable();
            $table->longText('comments')->nullable();
            $table->string('onset')->nullable();
            $table->string('snowed')->nullable();
            $table->enum('status', ['0', '1'])->default('1');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('problems');
    }
};
