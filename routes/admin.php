<?php

use App\Http\Controllers\Admin\AdmissionController;
use App\Http\Controllers\Admin\BedController;
use App\Http\Controllers\Admin\EncounterController;
use App\Http\Controllers\Admin\MaintenanceController;
use App\Http\Controllers\Admin\OperationController;
use App\Http\Controllers\Admin\PatientController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\SchedulingController;
use App\Http\Controllers\Admin\WebsiteSettingController;
use App\Http\Controllers\FloorController;
use App\Http\Controllers\TweetController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::resource('user', UserController::class);
    Route::get('/patients', [PatientController::class, 'index'])->name('patients.index');
    Route::get('/patient/create', [PatientController::class, 'create'])->name('patients.create');
    Route::post('/patient/store', [PatientController::class, 'store'])->name('patients.store');
    Route::delete('/patient/delete/{user_id}', [PatientController::class, 'destroy'])->name('patients.destroy');
    Route::put('/patient/update/{id}', [PatientController::class, 'update'])->name('patient.update');
    Route::get('/patients', [PatientController::class, 'index'])->name('patients.index');
    Route::get('/patient-edit/{id}', [PatientController::class, 'edit'])->name('patient.edit');
    Route::get('/fetch-patients/{tabId}', [PatientController::class, 'fetchPatients'])->name('fetch-patients');
    Route::resource('roles', RoleController::class);
    Route::resource('floors', FloorController::class);
    Route::get('/mapping/{id}', [FloorController::class, 'mapping'])->name('floors.mapping');
    Route::post('/assign-bed', [FloorController::class, 'assign_bed'])->name('patients.assign');
    Route::post('/patients/transfer', [FloorController::class, 'transfer_patient'])->name('patients.transfer');
    Route::resource('maintenance', MaintenanceController::class);
    Route::get('/maintenance', [TweetController::class, 'admin_index'])->name('maintenance.admin_index');
    Route::get('/tweets/load-more', [TweetController::class, 'loadMore'])->name('tweets.loadMore');
    Route::post('/update-roles', [UserController::class, 'updateRoles'])->name('update.roles');
    Route::resource('operations', OperationController::class);
    Route::get('/operations/load-more', [OperationController::class, 'loadMore'])->name('tweets.loadMore');
//    Encounters
    Route::resource('encounters', EncounterController::class);
    Route::get('/encounter-pdf/{encounter_id}', [EncounterController::class, 'get_pdf'])->name('encounter.pdf');
    Route::POST('export-users', [EncounterController::class, 'exportEncounter'])->name('export.encounter');
    Route::get('/encounter-details/{encounter_id}', [EncounterController::class, 'show'])->name('encounter.details');
    Route::post('/import-patients', [PatientController::class, 'import'])->name('patients.import');
//    Website Setup
    Route::get('/website-setup', [WebsiteSettingController::class, 'index'])->name('website-setup.index');
    Route::post('/website-setup-store', [WebsiteSettingController::class, 'store'])->name('website-setup.store');
    Route::get('/scheduling', [SchedulingController::class, 'index'])->name('scheduling.index');
    Route::get('/admissions', [AdmissionController::class, 'index'])->name('admissions.index');
    Route::post('/handle-bed-behavior', [BedController::class, 'handle_bed_behavior'])->name('handle-bed-behavior');


});

require __DIR__ . '/auth.php';
