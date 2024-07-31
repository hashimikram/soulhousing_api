<?php

use App\Http\Controllers\Admin\PatientController;
use App\Http\Controllers\Admin\RoleController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::get('/patients', [PatientController::class, 'index'])->name('patients.index');
    Route::get('/patient/create', [PatientController::class, 'create'])->name('patients.create');
    Route::post('/patient/store', [PatientController::class, 'store'])->name('patients.store');
    Route::get('/fetch-patients/{tabId}', [PatientController::class, 'fetchPatients'])->name('patients.fetch');
    Route::resource('roles', RoleController::class);
});

require __DIR__.'/auth.php';
