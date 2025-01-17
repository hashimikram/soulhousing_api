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
        Schema::create('encounter_note_sections', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('provider_id');
            $table->foreign('provider_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('patient_id');
            $table->foreign('patient_id')->references('id')->on('patients')->onDelete('cascade');
            $table->unsignedBigInteger('encounter_id');
            $table->foreign('encounter_id')->references('id')->on('patient_encounters')->onDelete('cascade');
            $table->string('id_default');
            $table->string('section_title')->nullable();
            $table->string('section_slug')->nullable();
            $table->longText('section_text')->nullable();
            $table->longText('section_json')->nullable();
            $table->string('sorting_order')->nullable();
            $table->json('attached_entities')->nullable();
            $table->text('assessment_note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('encounter_note_sections');
    }
};
