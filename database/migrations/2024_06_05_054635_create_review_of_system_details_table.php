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
        Schema::create('review_of_system_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('provider_id');
            $table->foreign('provider_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('patient_id');
            $table->foreign('patient_id')->references('id')->on('patients')->onDelete('cascade');
            $table->unsignedBigInteger('section_id');
            $table->foreign('section_id')->references('id')->on('encounter_note_sections')->onDelete('cascade');
            $table->string('constitutional')->nullable();
            $table->string('heent')->nullable();
            $table->text('general')->default('Weight loss, weight gain, or fatigue. Denies fever, chills, or night sweats.');
            $table->text('skin')->default('Denies rashes, itching, or bruising. Skin is warm and dry with normal turgor.');
            $table->text('head')->default('Denies headaches, trauma, or dizziness. Scalp and skull are normal upon');
            $table->text('eyes')->default('Denies vision changes, redness, or discharge. Pupils are equal, round, and reactive to light and accommodation. Extraocular movements are intact.');
            $table->text('ears')->default('Denies hearing loss, tinnitus, or ear pain. Tympanic membranes are clear with normal landmarks.');
            $table->text('nose')->default('Denies nasal congestion, discharge, or nosebleeds. Nasal passages are clear.');
            $table->text('mouth_throat')->default('Denies sore throat, difficulty swallowing, or mouth sores. Oral mucosa is moist, and oropharynx is clear without erythema or exudates.');
            $table->text('neck')->default('Denies lumps, swelling, or stiffness. Neck is supple with full range of motion. No lymphadenopathy.');
            $table->text('respiratory')->default(' Denies cough, shortness of breath, or wheezing. Breath sounds are clear to auscultation bilaterally. No rales, rhonchi, or wheezes.');
            $table->text('cardiovascular')->default('Denies chest pain, palpitations, or edema. Heart rate and rhythm are regular. No murmurs, rubs, or gallops. Peripheral pulses are intact.');
            $table->text('gastrointestinal')->default('Denies abdominal pain, nausea, vomiting, diarrhea, or constipation. Abdomen is soft, non-tender, and non-distended. Bowel sounds are normal.');
            $table->text('genitourinary')->default('Denies dysuria, hematuria, or urinary frequency. Denies genital lesions or discharge. Normal urination.');
            $table->text('musculoskeletal')->default('Denies joint pain, swelling, or stiffness. Full range of motion in all extremities. No deformities or tenderness.');
            $table->text('neurological')->default('Denies weakness, numbness, or seizures. Cranial nerves II-XII are intact. Strength and sensation are normal. Reflexes are 2+ and symmetrical.');
            $table->text('psychiatric')->default('Denies anxiety, depression, or mood changes. Normal affect and behavior. Oriented to person, place, and time.');
            $table->text('endocrine')->default('Denies polyuria, polydipsia, or heat/cold intolerance. Thyroid is not enlarged.');
            $table->text('hematologic_lymphatic')->default('Denies easy bruising, bleeding, or lymph node enlargement. No pallor or cyanosis.');
            $table->text('allergic_immunologic')->default('Denies known allergies. Denies history of frequent infections or autoimmune diseases.');
            $table->string('Integumentry')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('review_of_system_details');
    }
};
