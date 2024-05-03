<?php

use App\Http\Controllers\Api\AllergyController;
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
use App\Http\Controllers\FileController;
use App\Http\Controllers\ListOptionController;

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
    Route::post('/check-patient-record', [PatientController::class, 'check_availablity']);
    Route::post('/add-patient', [PatientController::class, 'store']);
    Route::get('/get-patients', [PatientController::class, 'index']);
    Route::get('/patient-detail/{patientId}', [PatientController::class, 'show']);
    Route::post('/update-patient', [PatientController::class, 'update']);
    Route::get('/delete-patient/{patient}', [PatientController::class, 'destroy']);
    Route::post('/search-patient', [PatientController::class, 'search']);


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
    Route::get('/floors', [FloorController::class, 'index']);
    Route::get('/rooms-beds/{floor_id}', [FloorController::class, 'bedsAndrooms']);

    // PIN CRUD
    Route::post('/set-pin', [PinController::class, 'store']);

    // Medication CRUD
    Route::post('/add-medication', [MedicationController::class, 'store']);
    Route::post('/update-medication', [MedicationController::class, 'update']);
    Route::get('/get-medication/{id}', [MedicationController::class, 'index']);
    Route::get('/delete-medication/{medication}', [MedicationController::class, 'destroy']);

    // Encounter CRUD
    Route::post('/add-patient-encounter', [PatientEncounterController::class, 'store']);
    Route::get('patient-encounter/{patient_id}', [PatientEncounterController::class, 'show']);
    Route::get('patient-encounter-notes/{encounter_id}', [PatientEncounterController::class, 'encounter_notes']);
    Route::get('delete-patient-encounter/{id}', [PatientEncounterController::class, 'destroy']);
    Route::post('/update-patient-encounter', [PatientEncounterController::class, 'update']);
    Route::post('/update-patient-encounter-notes', [EncounterNoteSectionController::class, 'update']);

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



    Route::get('/file/{name}', [FileController::class, 'show']);
    Route::get('/list-options', [ListOptionController::class, 'index']);


});
