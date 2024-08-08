<?php

use App\Http\Controllers\Admin\MaintenanceController;
use App\Http\Controllers\Admin\PatientController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\FloorController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::resource('user', UserController::class);
    Route::get('/patients', [PatientController::class, 'index'])->name('patients.index');
    Route::get('/patient/create', [PatientController::class, 'create'])->name('patients.create');
    Route::post('/patient/store', [PatientController::class, 'store'])->name('patients.store');
    Route::get('/fetch-patients/{tabId}', [PatientController::class, 'fetchPatients'])->name('patients.fetch');
    Route::resource('roles', RoleController::class);
    Route::resource('floors', FloorController::class);
    Route::get('/mapping/{id}', [FloorController::class, 'mapping'])->name('floors.mapping');
    Route::post('/assign-bed', [FloorController::class, 'assign_bed'])->name('patients.assign');
    Route::resource('maintenance', MaintenanceController::class);
    Route::post('/update-roles', [UserController::class, 'updateRoles'])->name('update.roles');

});

require __DIR__.'/auth.php';
