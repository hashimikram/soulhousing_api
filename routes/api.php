<?php

use App\Http\Controllers\Api\ContactController;
use App\Http\Controllers\Api\InsuranceController;
use App\Http\Controllers\Api\PatientController;
use App\Http\Controllers\Api\ProblemController;
use App\Http\Controllers\Auth\RegisteredUserController;
use Illuminate\Support\Facades\Route;

Route::post('login', [RegisteredUserController::class, 'login']);
// Forgot Password
Route::post('/forgot-password', [RegisteredUserController::class, 'forgot_password']);
Route::post('/reset-password', [RegisteredUserController::class, 'reset_password']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [RegisteredUserController::class, 'destroy']);

    // Patient CRUD
    Route::post('/add-patient', [PatientController::class, 'store']);
    Route::get('/get-patients', [PatientController::class, 'index']);
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
});
