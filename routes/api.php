<?php

use App\Http\Controllers\Api\AllergyController;
use App\Http\Controllers\Api\BedController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PinController;
use App\Http\Controllers\Api\NoteController;
use App\Http\Controllers\Api\FloorController;
use App\Http\Controllers\Api\ContactController;
use App\Http\Controllers\Api\PatientController;
use App\Http\Controllers\Api\ProblemController;
use App\Http\Controllers\Api\DocumentController;
use App\Http\Controllers\Api\InsuranceController;
use App\Http\Controllers\Api\MedicationController;
use App\Http\Controllers\Api\ReviewOfSystemController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Api\PatientEncounterController;
use App\Http\Controllers\Api\EncounterNoteSectionController;
use App\Http\Controllers\Api\VitalController;
use App\Http\Controllers\EncounterTemplateController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\ListOptionController;
use App\Models\EncounterTemplate;

Route::post('login', [RegisteredUserController::class, 'login']);
// Forgot Password
Route::post('/forgot-password', [RegisteredUserController::class, 'forgot_password']);
Route::post('/reset-password', [RegisteredUserController::class, 'reset_password']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [RegisteredUserController::class, 'destroy']);
    Route::post('/change-password', [RegisteredUserController::class, 'change_password']);
    Route::get('/login-user-details', [RegisteredUserController::class, 'login_user_details']);
    Route::post('/update-profile', [RegisteredUserController::class, 'update_profile']);

    // Patient CRUD
    Route::post('/check-patient-record', [PatientController::class, 'check_availability']);
    Route::post('/add-patient', [PatientController::class, 'store']);
    Route::get('/get-patients', [PatientController::class, 'index']);
    Route::get('/patient-detail/{patientId}', [PatientController::class, 'show']);
    Route::post('/update-patient', [PatientController::class, 'update']);
    Route::get('/delete-patient/{patient}', [PatientController::class, 'destroy']);
    Route::get('/search-patient/{search_text}', [PatientController::class, 'search']);

    // Insurance CRUD
    Route::post('/add-insurance', [InsuranceController::class, 'store']);
    Route::get('/get-insurance/{patient_id}', [InsuranceController::class, 'index']);
    Route::post('/update-insurance', [InsuranceController::class, 'update']);
    Route::get('/delete-insurance/{insurance}', [InsuranceController::class, 'destroy']);

    // Contact CRUD
    Route::post('/add-contact', [ContactController::class, 'store']);
    Route::get('/get-contact/{patient_id}', [ContactController::class, 'index']);
    Route::post('/update-contact', [ContactController::class, 'update']);
    Route::get('/delete-contact/{contact}', [ContactController::class, 'destroy']);

    // Problem CRUD
    Route::post('/add-problem', [ProblemController::class, 'store']);
    Route::get('/get-problem/{patient_id}', [ProblemController::class, 'index']);
    Route::post('/update-problem', [ProblemController::class, 'update']);
    Route::get('/delete-problem/{problem}', [ProblemController::class, 'destroy']);
    Route::post('/search-problem', [ProblemController::class, 'search']);

    // Floor and Room CRUD
    Route::post('/add-floor-rooms', [FloorController::class, 'store']);
    Route::post('/update-room', [FloorController::class, 'update_room']);
    Route::post('/update-beds', [FloorController::class, 'update_bed']);
    Route::get('/floors', [FloorController::class, 'index']);
    Route::post('/assign-bed', [BedController::class, 'assign_bed']);
    Route::post('/update-patient-bed', [BedController::class, 'update_patient_bed']);
    Route::get('/bed-details/{id}', [BedController::class, 'show']);
    Route::get('/rooms-beds/{floor_id}', [FloorController::class, 'bedsAndrooms']);
    Route::get('/map-rooms-beds/{floor_id}', [FloorController::class, 'mapBedRooms']);

    // PIN CRUD
    Route::post('/set-pin', [PinController::class, 'store']);

    // Medication CRUD
    Route::post('/add-medication', [MedicationController::class, 'store']);
    Route::post('/update-medication', [MedicationController::class, 'update']);
    Route::get('/get-medication/{id}', [MedicationController::class, 'index']);
    Route::get('/delete-medication/{medication}', [MedicationController::class, ' destroy']);

    // Encounter CRUD
    Route::post('/add-patient-encounter', [PatientEncounterController::class, 'store']);
    Route::post('/add-patient-encounter-notes', [PatientEncounterController::class, 'encounter_notes_store']);
    Route::get('patient-encounter/{patient_id}', [PatientEncounterController::class, 'show']);
    Route::get('patient-encounter-notes/{encounter_id}', [PatientEncounterController::class, 'encounter_notes']);
    Route::get('delete-patient-encounter/{id}', [PatientEncounterController::class, 'destroy']);
    Route::post('/update-patient-encounter', [PatientEncounterController::class, 'update']);
    Route::post('/update-patient-encounter-notes', [EncounterNoteSectionController::class, 'update']);
    Route::get('patient-encounter-information/{patient_id}', [PatientEncounterController::class, 'patient_encounter_information']);
    Route::post('/encounter-status-update', [PatientEncounterController::class, 'status_update']);

    // ReviewOfSystem CRUD
    Route::post('/add-review-of-system', [ReviewOfSystemController::class, 'store']);
    Route::get('/delete-review-of-system/{id}', [ReviewOfSystemController::class, 'destroy']);
    Route::get('review-of-system/{patient_id}', [ReviewOfSystemController::class, 'show']);
    Route::post('/update-review-of-system', [ReviewOfSystemController::class, 'update']);
    Route::get('/patient-summary/{id}', [PatientController::class, 'summary_patient']);

    // Note CRUD
    Route::get('/notes/{patient_id}', [NoteController::class, 'index']);
    Route::post('/notes-search/{patient_id}', [NoteController::class, 'search']);
    Route::get('/single-note/{id}', [NoteController::class, 'show']);
    Route::post('/store-note', [NoteController::class, 'store']);
    Route::put('/notes/{id}', [NoteController::class, 'update']);
    Route::delete('/notes/{id}', [NoteController::class, 'destroy']);

    // Document CRUD
    Route::get('/documents/{patient_id}', [DocumentController::class, 'index']);
    Route::post('/store-document', [DocumentController::class, 'store']);
    Route::delete('/document/{id}', [DocumentController::class, 'destroy']);
    Route::post('/update-document', [DocumentController::class, 'update']);
    Route::post('/search-document', [DocumentController::class, 'search']);

    // Allergy CRUD
    Route::post('/store-allergy', [AllergyController::class, 'store']);
    Route::get('/allergies/{patient_id}', [AllergyController::class, 'index']);
    Route::get('/single-allergy/{id}', [AllergyController::class, 'show']);
    Route::delete('/delete-allergy/{id}', [AllergyController::class, 'destroy']);
    Route::post('/update-allergy', [AllergyController::class, 'update']);
    Route::post('/search-allergy', [AllergyController::class, 'search']);

    // Vitals CRUD
    Route::post('/store-vital', [VitalController::class, 'store']);
    Route::get('/vitals/{patient_id}', [VitalController::class, 'index']);
    Route::get('/single-vital/{id}', [VitalController::class, 'show']);
    Route::delete('/delete-vital/{id}', [VitalController::class, 'destroy']);
    Route::post('/update-vital', [VitalController::class, 'update']);
    Route::post('/search-vital', [VitalController::class, 'search']);


    Route::get('/file/{name}', [FileController::class, 'show']);
    Route::get('/list-options', [ListOptionController::class, 'index']);
    Route::post('/encounter-template', [EncounterTemplateController::class, 'store']);
    Route::get('/get/encounter-template', [EncounterTemplateController::class, 'index']);
});
