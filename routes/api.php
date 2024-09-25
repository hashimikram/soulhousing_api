<?php

use App\Http\Controllers\AcknowledgeController;
use App\Http\Controllers\AdmissionDischargeController;
use App\Http\Controllers\Api\AclController;
use App\Http\Controllers\Api\AllergyController;
use App\Http\Controllers\Api\BedController;
use App\Http\Controllers\Api\ContactController;
use App\Http\Controllers\Api\DocumentController;
use App\Http\Controllers\Api\EncounterNoteSectionController;
use App\Http\Controllers\Api\FloorController;
use App\Http\Controllers\Api\InsuranceController;
use App\Http\Controllers\Api\MedicationController;
use App\Http\Controllers\Api\NoteController;
use App\Http\Controllers\Api\NotepadController;
use App\Http\Controllers\Api\PatientController;
use App\Http\Controllers\Api\PatientEncounterController;
use App\Http\Controllers\Api\PinController;
use App\Http\Controllers\Api\ProblemController;
use App\Http\Controllers\Api\ReviewOfSystemController;
use App\Http\Controllers\Api\SchedulingController;
use App\Http\Controllers\Api\VitalController;
use App\Http\Controllers\AssessmentNoteController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\CptCodeController;
use App\Http\Controllers\DischargedPatientsController;
use App\Http\Controllers\DischargeFormController;
use App\Http\Controllers\EncounterTemplateController;
use App\Http\Controllers\Encountertest;
use App\Http\Controllers\FacilityController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\ListOptionController;
use App\Http\Controllers\MedicalLetterController;
use App\Http\Controllers\OperationAcknowledgeController;
use App\Http\Controllers\OperationCommentController;
use App\Http\Controllers\OperationController;
use App\Http\Controllers\OperationLikeController;
use App\Http\Controllers\PhysicalExamDetailController;
use App\Http\Controllers\ProblemQuoteController;
use App\Http\Controllers\ReviewOfSystemDetailController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\TweetController;
use App\Http\Controllers\WarningController;
use App\Http\Controllers\WoundController;
use Illuminate\Support\Facades\Route;

Route::post('login', [RegisteredUserController::class, 'login']);
// Forgot Password
Route::post('/forgot-password', [RegisteredUserController::class, 'forgot_password']);
Route::post('/reset-password', [RegisteredUserController::class, 'reset_password']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [RegisteredUserController::class, 'destroy']);
    Route::post('/change-password', [RegisteredUserController::class, 'change_password']);
    Route::get('/login-user-details', [RegisteredUserController::class, 'login_user_details']);
    Route::post('/update-profile', [RegisteredUserController::class, 'update_profile']);

    // patients CRUD
    Route::post('/check-patient-record', [PatientController::class, 'check_availability']);
    Route::post('/add-patient', [PatientController::class, 'store']);
    Route::get('/get-patients', [PatientController::class, 'index']);
    Route::get('/my-patients', [PatientController::class, 'my_patients']);
    Route::get('/un-assigned-patients', [PatientController::class, 'un_assigned_patients']);
    Route::get('/un-sign-patients', [PatientController::class, 'un_sign_patients']);
    Route::get('/patient-detail/{patientId}', [PatientController::class, 'show']);
    Route::post('/update-patient', [PatientController::class, 'update']);
    Route::get('/delete-patient/{patient}', [PatientController::class, 'destroy']);
    Route::get('/search-patient/{search_text}', [PatientController::class, 'search']);

    Route::get('/us-states', [PatientController::class, 'states']);

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
    Route::post('/add-problem/note-section', [ProblemController::class, 'store_note_section']);
    Route::post('/add-cpt/note-section', [ProblemController::class, 'store_cpt_section']);

    // Floor and Room CRUD
    Route::post('/add-floor-rooms', [FloorController::class, 'store']);
    Route::post('/edit_floor', [FloorController::class, 'update']);
    Route::post('/update-room', [FloorController::class, 'update_room']);
    Route::get('/delete-room/{room_id}', [RoomController::class, 'delete_room']);
    Route::post('/update-beds', [FloorController::class, 'update_bed']);
    Route::get('/delete-bed/{bed_id}', [BedController::class, 'delete_bed']);
    Route::get('/floors', [FloorController::class, 'index']);
    Route::post('/assign-bed', [BedController::class, 'assign_bed']);
    Route::post('/update-patient-bed', [BedController::class, 'update_patient_bed']);
    Route::get('/bed-details/{id}', [BedController::class, 'show']);
    Route::get('/rooms-beds/{floor_id}', [FloorController::class, 'bedsAndrooms']);
    Route::get('/map-rooms-beds/{floor_id}', [FloorController::class, 'mapBedRooms']);
    Route::get('/get-vacant-beds/{status}', [FloorController::class, 'all_floors_by_status']);
    Route::get('/get-unprepared-beds/{status}', [FloorController::class, 'get_unprepared_beds']);
    Route::post('/add-new-room', [RoomController::class, 'store']);
    Route::post('/add-new-bed', [BedController::class, 'store']);
    Route::post('/update-room', [RoomController::class, 'update']);
    Route::post('/update-beds', [BedController::class, 'update']);
    Route::post('/discharge-patient-bed', [BedController::class, 'discharge_patient_bed']);
    Route::post('/unprepared-to-vacant', [BedController::class, 'markAsVacant']);
    Route::post('/hospitalized-patient-bed', [BedController::class, 'markAsHospitalized']);
    Route::post('/reassign-patient-bed', [BedController::class, 'markAsReassign']);
    // PIN CRUD
    Route::post('/set-pin', [PinController::class, 'store']);

    // Medication CRUD
    Route::post('/add-medication', [MedicationController::class, 'store']);
    Route::post('/update-medication', [MedicationController::class, 'update']);
    Route::get('/get-medication/{id}', [MedicationController::class, 'index']);
    Route::get('/delete-medication/{medication}', [MedicationController::class, ' destroy']);
    Route::post('/change-status-medication', [MedicationController::class, 'change_status']);
    // Encounter CRUD
    Route::post('/add-patient-encounter', [PatientEncounterController::class, 'store']);
    Route::get('/get-patient-encounter/{encounter_id}', [Encountertest::class, 'get_encounter']);
    Route::get('/get-pdf/{encounter_id}', [Encountertest::class, 'get_pdf']);

    Route::post('/add-patient-encounter-notes', [PatientEncounterController::class, 'encounter_notes_store']);
    Route::get('patient-encounter/{patient_id}', [PatientEncounterController::class, 'show']);
    Route::get('patient-encounter-notes/{encounter_id}', [PatientEncounterController::class, 'encounter_notes']);
    Route::get('delete-patient-encounter/{id}', [PatientEncounterController::class, 'destroy']);
    Route::post('/update-patient-encounter', [PatientEncounterController::class, 'update']);
    Route::post('/update-patient-encounter-notes', [EncounterNoteSectionController::class, 'update']);
    Route::get(
        'patient-encounter-information/{patient_id}',
        [PatientEncounterController::class, 'patient_encounter_information']
    );
    Route::post('/encounter-status-update', [PatientEncounterController::class, 'status_update']);
    Route::get('/get-details-review/{section_id}/{patient_id}', [ReviewOfSystemDetailController::class, 'show']);
    Route::get(
        '/get-details-mental/{section_id}/{patient_id}',
        [PatientEncounterController::class, 'mental_section_show']
    );
    Route::get('/get-details-physical/{section_id}/{patient_id}', [PhysicalExamDetailController::class, 'show']);
    Route::post('/update-details-review', [ReviewOfSystemDetailController::class, 'update']);
    Route::post('/update-details-physical', [PhysicalExamDetailController::class, 'update']);
    Route::post('/update-details-psychiatric', [PatientEncounterController::class, 'psychiatric_update']);
    Route::get(
        '/check-encounter-type/{patient_id}/{specialty_id}',
        [PatientEncounterController::class, 'check_patient_encounter']
    );
    Route::get('/encounter-report', [PatientEncounterController::class, 'pastPatientEncounters']);

    Route::post('/assessment-notes', [AssessmentNoteController::class, 'store']);
    Route::get('/delete-assessment-note/{id}/{value_id}', [AssessmentNoteController::class, 'destroy']);


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

    Route::get('/cpt-codes/{search_text}', [CptCodeController::class, 'search']);
    Route::get('/problem-quotes', [ProblemQuoteController::class, 'search']);

    Route::get('/file/{name}', [FileController::class, 'show']);
    Route::post('/file-show', [FileController::class, 'show_file']);
    Route::get('/list-options', [ListOptionController::class, 'index']);
    Route::post('/encounter-template', [EncounterTemplateController::class, 'store']);
    Route::get('/get/encounter-template', [EncounterTemplateController::class, 'index']);

    // TweetController
    Route::post('/store-tweet', [TweetController::class, 'store']);
    Route::get('/get-tweets', [TweetController::class, 'index']);
    Route::get('/tweets', [TweetController::class, 'index']);
    Route::get('/tweets/{tweet}', [TweetController::class, 'show']);
    Route::delete('/tweets/{tweet}', [TweetController::class, 'destroy']);
    Route::post('/like-post', [LikeController::class, 'store']);
    Route::post('/comment-post', [CommentController::class, 'store']);
    Route::post('/comments', [CommentController::class, 'getComments']);
    Route::post('/likes', [LikeController::class, 'getLikes']);

    // WarningController
    Route::post('/warning-store', [WarningController::class, 'store']);
    Route::get('/get-warnings/{patient_id}', [WarningController::class, 'index']);

    // MedicalLetterController
    Route::post('/medical-letter-store', [MedicalLetterController::class, 'store']);
    Route::get('/get-medical-letter/{patient_id}', [MedicalLetterController::class, 'index']);

    // AdmissionDischargeController
    Route::post('/store-admission-discharge', [AdmissionDischargeController::class, 'store']);
    Route::get('/get-admission-discharge/{patient_id}', [AdmissionDischargeController::class, 'index']);
    Route::get('/get-admission-types', [AdmissionDischargeController::class, 'create']);
    Route::get('/delete-admission-discharge/{id}', [AdmissionDischargeController::class, 'destroy']);
    Route::post('/update-admission-discharge', [AdmissionDischargeController::class, 'update']);
    Route::get('/discharge-patient/{id}', [AdmissionDischargeController::class, 'discharge_patient']);
    Route::get('/get-discharged-patients/{patient_id}', [AdmissionDischargeController::class, 'discharged_patients']);
    Route::post('/discharge-patient', [DischargedPatientsController::class, 'store']);
    Route::get('/admission-vacant-beds', [AdmissionDischargeController::class, 'get_vacant_beds']);
    Route::post('/close-admission', [AdmissionDischargeController::class, 'close_admission']);
    Route::get('/discharge-pdf/{admission_id}', [AdmissionDischargeController::class, 'get_pdf']);


    //    WoundController
    Route::post('/store-wound', [WoundController::class, 'store']);
    Route::post('/operation-store-tweet', [OperationController::class, 'store']);
    Route::get('/operation-get-tweets', [OperationController::class, 'index']);
    Route::get('/operation-tweets', [OperationController::class, 'index']);
    Route::get('/operation-tweets/{tweet}', [OperationController::class, 'show']);
    Route::delete('/operation-tweets/{tweet}', [OperationController::class, 'destroy']);
    Route::post('/operation-like-post', [OperationLikeController::class, 'store']);
    Route::post('/operation-comment-post', [OperationCommentController::class, 'store']);
    Route::post('/operation-acknowledge-post', [OperationAcknowledgeController::class, 'store']);
    Route::post('/operation-comments', [OperationCommentController::class, 'getComments']);
    Route::post('/operation-likes', [OperationLikeController::class, 'getLikes']);
    Route::get('/search-code/{search_text}', [ProblemQuoteController::class, 'search_problem']);

    //    SchedulingController
    Route::get('/get-scheduling', [SchedulingController::class, 'index']);
    Route::post('/store-scheduling', [SchedulingController::class, 'store']);
    Route::get('/get-maintenance-operation-team', [SchedulingController::class, 'getMaintenanceAndOperationsTeam']);
    Route::get('/todo-list', [SchedulingController::class, 'toDoList']);

    // NotePadRoutes
    Route::get('/get-notepad/{patient_id}', [NotepadController::class, 'index']);
    Route::post('/store-notepad', [NotepadController::class, 'store']);
    Route::post('/update-notepad', [NotepadController::class, 'update']);

    Route::get('/all-providers', [PatientController::class, 'all_providers']);
    Route::get('/get-latest-vitals/{patient_id}', [VitalController::class, 'get_latest_vital']);
    Route::get('/all-facilities', [FacilityController::class, 'all_facilities']);
    Route::get('/login-user-facility', [FacilityController::class, 'LoginUserFacility']);
    Route::post('/update-login-facility', [FacilityController::class, 'updateLoginUserFacility']);
    Route::get('/discharge-form/{patient_id}', [DischargeFormController::class, 'index']);
    Route::get('/roles-permissions', [AclController::class, 'index']);
    Route::post('/blacklist-patient', [PatientController::class, 'blacklist_patient']);
    Route::get('/updated-patient-details/{patient_id}', [PatientController::class, 'getUpdatedPatientDetails']);
});
