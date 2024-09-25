<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\AdminProfileController;
use App\Http\Controllers\Api\PatientController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\FacilityController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\TweetController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('backend.auth.login');
});

Route::get('/import', function () {
    return view('backend.import');
});

Route::get('/check-page', function () {
    return view('PDF.status_change');
});

Route::get('/generate-pdf', [PdfController::class, 'generatePdf']);

Route::get('/testing-form', function () {
    return view('PDF.wond_pdf');
});
Route::post('/save-data', [\App\Http\Controllers\Api\FloorController::class, 'form_data'])->name('save.data');

Route::get('/dashboard', [AdminController::class, 'index'])->middleware([
    'auth', 'verified'
])->name('dashboard');

Route::middleware('auth')->group(function () {

    Route::resource('facility', FacilityController::class);
    Route::resource('admin', AdminProfileController::class);
    Route::resource('sub-admin', StaffController::class);

    Route::get('/likes', [LikeController::class, 'getLikes_admin']);
    Route::get('/comments', [CommentController::class, 'index']);
    Route::post('/give-review-maintenance', [TweetController::class, 'give_review'])->name('maintenance.give_review');
    Route::get('/patients/search', [PatientController::class, 'search_admin'])->name('patients.search');

});

require __DIR__.'/auth.php';
