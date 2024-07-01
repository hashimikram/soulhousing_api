<?php

use App\Http\Controllers\AdminProfileController;
use App\Http\Controllers\Api\FloorController;
use App\Http\Controllers\FacilityController;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('admin.auth.login');
});

Route::get('/generate-pdf', [PdfController::class, 'generatePdf']);

Route::get('/testing-form', function () {
    return view('testing');
});
Route::post('/save-data', [\App\Http\Controllers\Api\FloorController::class, 'form_data'])->name('save.data');

Route::get('/dashboard', function () {
    return view('admin.index');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::resource('user', UserController::class);
    Route::resource('facility', FacilityController::class);
    Route::resource('admin', AdminProfileController::class);
    Route::resource('floors', FloorController::class);
});

require __DIR__.'/auth.php';
