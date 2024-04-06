<?php

use App\Http\Controllers\Api\ContactController;
use App\Http\Controllers\Api\FloorController;
use App\Http\Controllers\Api\InsuranceController;
use App\Http\Controllers\Api\MedicationController;
use App\Http\Controllers\Api\PatientController;
use App\Http\Controllers\Api\PatientEncounterController;
use App\Http\Controllers\Api\PinController;
use App\Http\Controllers\Api\ProblemController;
use App\Http\Controllers\Api\ReviewOfSystemController;
use App\Http\Controllers\Auth\RegisteredUserController;
use Illuminate\Support\Facades\Route;

Route::post('login', [RegisteredUserController::class, 'login']);
// Forgot Password
Route::post('/forgot-password', [RegisteredUserController::class, 'forgot_password']);
Route::post('/reset-password', [RegisteredUserController::class, 'reset_password']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [RegisteredUserController::class, 'destroy']);
    Route::post('/change-password', [RegisteredUserController::class, 'change_password']);

    // Patient CRUD
    Route::post('/add-patient', [PatientController::class, 'store']);
    Route::get('/get-patients', [PatientController::class, 'index']);
    Route::get('/patient-detail/{patientId}', [PatientController::class, 'show']);
    Route::post('/update-patient', [PatientController::class, 'update']);
    Route::get('/delete-patient/{patient}', [PatientController::class, 'destroy']);

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

    // Floor and Room CRUD
    Route::post('/add-floor-rooms', [FloorController::class, 'store']);
    Route::get('/floors', [FloorController::class, 'index']);
    Route::get('/rooms-beds/{floor_id}', [FloorController::class, 'bedsAndrooms']);

    // PIN CRUD
    Route::post('/set-pin', [PinController::class, 'store']);

    // Medication CRUD
    Route::post('/add-medication', [MedicationController::class, 'store']);
    Route::post('/update-medication', [MedicationController::class, 'update']);
    Route::get('/get-medication', [MedicationController::class, 'index']);
    Route::get('/delete-medication/{medication}', [MedicationController::class, 'destroy']);

    // Encounter CRUD
    Route::post('/add-patient-encounter', [PatientEncounterController::class, 'store']);
    Route::get('patient-encounter/{patient_id}', [PatientEncounterController::class, 'show']);
    Route::get('patient-encounter-notes/{encounter_id}', [PatientEncounterController::class, 'encounter_notes']);
    Route::get('delete-patient-encounter/{id}', [PatientEncounterController::class, 'destroy']);
    Route::post('/update-patient-encounter', [PatientEncounterController::class, 'update']);
    // ReviewOfSystem CRUD
    Route::post('/add-review-of-system', [ReviewOfSystemController::class, 'store']);
    Route::get('/delete-review-of-system/{id}', [ReviewOfSystemController::class, 'destroy']);
    Route::get('review-of-system/{patient_id}', [ReviewOfSystemController::class, 'show']);
    Route::post('/update-review-of-system', [ReviewOfSystemController::class, 'update']);

});
