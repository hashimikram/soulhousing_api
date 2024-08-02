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
        Schema::create('wounds', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('provider_id');
            $table->foreign('provider_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('patient_id');
            $table->foreign('patient_id')->references('id')->on('patients')->onDelete('cascade');
            $table->string('encounter_id')->nullable();
            $table->text('right_dp')->nullable();
            $table->text('right_pt')->nullable();
            $table->text('left_dp')->nullable();
            $table->text('left_pt')->nullable();
            $table->text('right_temp')->nullable();
            $table->text('left_temp')->nullable();
            $table->text('right_hair')->nullable();
            $table->text('left_hair')->nullable();
            $table->text('right_prick')->nullable();
            $table->text('left_prick')->nullable();
            $table->text('right_touch')->nullable();
            $table->text('left_touch')->nullable();
            $table->text('right_mono')->nullable();
            $table->text('left_mono')->nullable();
            $table->text('other_factor')->nullable();
            $table->text('patient_education')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wounds');
    }
};
