<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Models\Contact;
<<<<<<< HEAD
=======
<<<<<<< HEAD
>>>>>>> 5f5cac5326938618709759d14757778d0bd916b2
use App\Models\patient;
use App\Models\Problem;
use App\Models\medication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Api\BaseController as BaseController;
<<<<<<< HEAD
=======
=======
use Carbon\Carbon;
use App\Models\Contact;
use App\Models\patient;
use App\Models\Problem;
use App\Models\medication;
use App\Models\Problem;
use App\Models\medication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Api\BaseController as BaseController;
use App\Http\Controllers\Api\BaseController as BaseController;
>>>>>>> 1c7f9ed22f1a431c9cef97cd82022b8454954102
>>>>>>> 5f5cac5326938618709759d14757778d0bd916b2

class PatientController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $patients = Patient::leftJoin('problems', 'problems.patient_id', '=', 'patients.id')
            ->leftJoin('beds', 'beds.patient_id', '=', 'patients.id')
            ->leftJoin('rooms', 'beds.room_id', '=', 'rooms.id')
            ->leftJoin('floors', 'rooms.floor_id', '=', 'floors.id')
            ->leftJoin('insurances', 'insurances.patient_id', '=', 'patients.id')
            ->select('patients.*', 'problems.diagnosis as problem_name', 'floors.floor_name', 'rooms.room_name', 'beds.bed_no', 'insurances.insurance_name')
            ->where('patients.provider_id', auth()->user()->id)
            ->orderBy('patients.created_at', 'DESC')
            ->groupBy('patients.id') // Add 'patients.first_name' to the GROUP BY clause
            ->get();
        foreach ($patients as $data) {
            $data->admission_date = Carbon::now()->format('Y-m-d H:i A');
        }


<<<<<<< HEAD
=======
<<<<<<< HEAD
=======
        $patients = Patient::leftJoin('problems', 'problems.patient_id', '=', 'patients.id')
            ->leftJoin('beds', 'beds.patient_id', '=', 'patients.id')
            ->leftJoin('rooms', 'beds.room_id', '=', 'rooms.id')
            ->leftJoin('floors', 'rooms.floor_id', '=', 'floors.id')
            ->leftJoin('insurances', 'insurances.patient_id', '=', 'patients.id')
            ->select('patients.*', 'problems.diagnosis as problem_name', 'floors.floor_name', 'rooms.room_name', 'beds.bed_no', 'insurances.insurance_name')
            ->where('patients.provider_id', auth()->user()->id)
            ->orderBy('patients.created_at', 'DESC')
            ->groupBy('patients.id') // Add 'patients.first_name' to the GROUP BY clause
            ->get();
        foreach ($patients as $data) {
            $data->admission_date = Carbon::now()->format('Y-m-d H:i A');
        }


>>>>>>> 1c7f9ed22f1a431c9cef97cd82022b8454954102
>>>>>>> 5f5cac5326938618709759d14757778d0bd916b2
        $base = new BaseController();
        return $base->sendResponse($patients, 'All Patients Of Login Provider');
    }

    public function search($search_text)
    {
<<<<<<< HEAD

=======
<<<<<<< HEAD

=======
>>>>>>> 1c7f9ed22f1a431c9cef97cd82022b8454954102
>>>>>>> 5f5cac5326938618709759d14757778d0bd916b2
        $loggedInUserId = auth()->user()->id;
        $patients = Patient::leftJoin('problems', 'problems.patient_id', '=', 'patients.id')
            ->leftJoin('beds', 'beds.patient_id', '=', 'patients.id')
            ->leftJoin('rooms', 'beds.room_id', '=', 'rooms.id')
            ->leftJoin('floors', 'rooms.floor_id', '=', 'floors.id')
            ->leftJoin('insurances', 'insurances.patient_id', '=', 'patients.id')
            ->select('patients.*', 'problems.diagnosis as problem_name', 'floors.floor_name', 'rooms.room_name', 'beds.bed_no', 'insurances.insurance_name')
            ->where(function ($query) use ($search_text) {
                $query->where('first_name', 'LIKE', '%' . $search_text . '%')
                    ->orWhere('last_name', 'LIKE', '%' . $search_text . '%')
                    ->orWhere('mrn_no', 'LIKE', '%' . $search_text . '%');
            })
            ->orderBy('patients.created_at', 'DESC')
<<<<<<< HEAD
=======
<<<<<<< HEAD
>>>>>>> 5f5cac5326938618709759d14757778d0bd916b2
            ->groupBy('patients.id') // Add 'patients.first_name' to the GROUP BY clause
              ->where('patients.provider_id', auth()->user()->id)
            ->get();
        foreach ($patients as $data) {
            $data->admission_date = Carbon::now()->format('Y-m-d H:i A');
$data->patient_full_name = $data->first_name . ' ' . $data->last_name;
<<<<<<< HEAD
=======
=======
            ->where('patients.provider_id', auth()->user()->id)
            ->groupBy('patients.id') // Add 'patients.first_name' to the GROUP BY clause
            ->get();
        foreach ($patients as $data) {
            $data->admission_date = Carbon::now()->format('Y-m-d H:i A');
>>>>>>> 1c7f9ed22f1a431c9cef97cd82022b8454954102
>>>>>>> 5f5cac5326938618709759d14757778d0bd916b2
        }


        $base = new BaseController();
        return $base->sendResponse($patients, 'Search Patients Of Login Provider');
<<<<<<< HEAD
=======
<<<<<<< HEAD
>>>>>>> 5f5cac5326938618709759d14757778d0bd916b2


    }

<<<<<<< HEAD
=======
=======
    }


>>>>>>> 1c7f9ed22f1a431c9cef97cd82022b8454954102
>>>>>>> 5f5cac5326938618709759d14757778d0bd916b2
    /**
     * Show the form for creating a new resource.
     */
    public function check_availability(Request $request)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'gender' => 'required',
        ]);
        $checkUnique = patient::where('first_name', $request->first_name)
            ->where('last_name', $request->last_name)
            ->where('gender', $request->gender)
            ->where('date_of_birth', $request->date_of_birth)
            ->get();
        $base = new BaseController();
        if (count($checkUnique) == 0) {
            return $base->sendResponse(NULL, 'No Patient Found');
        } else {
            return $base->sendError('Patient Already Exists');
        }
<<<<<<< HEAD
=======
<<<<<<< HEAD
=======
    public function check_availability(Request $request)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'gender' => 'required',
        ]);
        $checkUnique = patient::where('first_name', $request->first_name)
            ->where('last_name', $request->last_name)
            ->where('gender', $request->gender)
            ->where('date_of_birth', $request->date_of_birth)
            ->get();
        $base = new BaseController();
        if (count($checkUnique) == 0) {
            return $base->sendResponse(NULL, 'No Patient Found');
        } else {
            return $base->sendError('Patient Already Exists');
        }
>>>>>>> 1c7f9ed22f1a431c9cef97cd82022b8454954102
>>>>>>> 5f5cac5326938618709759d14757778d0bd916b2
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
<<<<<<< HEAD
=======
<<<<<<< HEAD
=======
            'first_name' => 'required',
            'last_name' => 'required',
>>>>>>> 1c7f9ed22f1a431c9cef97cd82022b8454954102
>>>>>>> 5f5cac5326938618709759d14757778d0bd916b2
            'ssn' => 'required',
            'gender' => 'required',
            'email' => 'required|email',
            'phone_no' => 'required',
<<<<<<< HEAD
        ]);
        $base = new BaseController();
        $checkUnique = patient::where('first_name', $request->first_name)
=======
<<<<<<< HEAD
        ]);
        $base = new BaseController();
        $checkUnique = patient::where('first_name', $request->first_name)
=======
            'email' => 'required|email',
            'phone_no' => 'required',
        ]);
        $base = new BaseController();
        $checkUnique = patient::where('first_name', $request->first_name)
        $checkUnique = patient::where('first_name', $request->first_name)
>>>>>>> 1c7f9ed22f1a431c9cef97cd82022b8454954102
>>>>>>> 5f5cac5326938618709759d14757778d0bd916b2
            ->where('last_name', $request->last_name)
            ->where('gender', $request->gender)
            ->where('date_of_birth', $request->date_of_birth)
            ->first();
        if ($checkUnique == NULL) {
<<<<<<< HEAD
=======
<<<<<<< HEAD
>>>>>>> 5f5cac5326938618709759d14757778d0bd916b2
            try {

                $patient = new patient();
                $patient->provider_id = auth()->user()->id;
                $patient->title = $request->title;
<<<<<<< HEAD
=======
=======
            ->first();
        if ($checkUnique == NULL) {
            try {


                $patient = new patient();
                $patient->provider_id = auth()->user()->id;
                $patient->title = $request->title;
                $patient->title = $request->title;
>>>>>>> 1c7f9ed22f1a431c9cef97cd82022b8454954102
>>>>>>> 5f5cac5326938618709759d14757778d0bd916b2
                $patient->first_name = $request->first_name;
                $patient->middle_name = $request->middle_name;
                $patient->last_name = $request->last_name;
                $patient->nick_name = $request->nick_name;
                $patient->phone_no = $request->phone_no;
                $patient->email = $request->email;
<<<<<<< HEAD
=======
<<<<<<< HEAD
=======
                $patient->phone_no = $request->phone_no;
                $patient->email = $request->email;
>>>>>>> 1c7f9ed22f1a431c9cef97cd82022b8454954102
>>>>>>> 5f5cac5326938618709759d14757778d0bd916b2
                $patient->suffix = $request->suffix;
                $patient->ssn = $request->ssn;
                $patient->gender = $request->gender;
                $patient->date_of_birth = $request->date_of_birth;
                $patient->general_identity = $request->general_identity;
                $patient->other = $request->other;
                $patient->location = $request->location;
                $patient->pharmacy = $request->pharmacy;
                $patient->address_1 = $request->address_1;
                $patient->address_2 = $request->address_2;
                $patient->city = $request->city;
                $patient->state = $request->state;
                $patient->zip_code = $request->zip_code;
                $patient->country = $request->country;
                $patient->save();
                $recentAdd = patient::find($patient->id);
                $countPatient = 'sk-' . str_pad($patient->id, 4, '0', STR_PAD_LEFT);
                $recentAdd->mrn_no = $countPatient;
                $recentAdd->save();
<<<<<<< HEAD
=======
<<<<<<< HEAD
=======
                $recentAdd = patient::find($patient->id);
                $countPatient = 'sk-' . str_pad($patient->id, 4, '0', STR_PAD_LEFT);
                $recentAdd->mrn_no = $countPatient;
                $recentAdd->save();
>>>>>>> 1c7f9ed22f1a431c9cef97cd82022b8454954102
>>>>>>> 5f5cac5326938618709759d14757778d0bd916b2
                $data['patient_id'] = $patient->id;
                return $base->sendResponse($data, 'Patient Added Successfully');
            } catch (\Exception $e) {

                return $base->sendError($e->getMessage());
<<<<<<< HEAD
=======
<<<<<<< HEAD
=======

                return $base->sendError($e->getMessage());
>>>>>>> 1c7f9ed22f1a431c9cef97cd82022b8454954102
>>>>>>> 5f5cac5326938618709759d14757778d0bd916b2
            }
        } else {
            // Existing patient found, include its data in the error response
            $existingPatientData = [];

            if ($checkUnique->first_name != $request->first_name) {
                $existingPatientData['first_name'] = 'First name already exists';
            }
            if ($checkUnique->last_name != $request->last_name) {
                $existingPatientData['last_name'] = 'Last name already exists';
            }
            if ($checkUnique->email != $request->email) {
                $existingPatientData['email'] = 'Email already exists';
            }
            if ($checkUnique->date_of_birth != $request->date_of_birth) {
                $existingPatientData['date_of_birth'] = 'Date of birth already exists';
            }
<<<<<<< HEAD

            return $base->sendError($existingPatientData);
=======
<<<<<<< HEAD

            return $base->sendError($existingPatientData);
=======
            // Existing patient found, include its data in the error response
            $existingPatientData = [];

            if ($checkUnique->first_name != $request->first_name) {
                $existingPatientData['first_name'] = 'First name already exists';
            }
            if ($checkUnique->last_name != $request->last_name) {
                $existingPatientData['last_name'] = 'Last name already exists';
            }
            if ($checkUnique->email != $request->email) {
                $existingPatientData['email'] = 'Email already exists';
            }
            if ($checkUnique->date_of_birth != $request->date_of_birth) {
                $existingPatientData['date_of_birth'] = 'Date of birth already exists';
            }

            return $base->sendError($existingPatientData);
        }
            return $base->sendError($existingPatientData);
>>>>>>> 1c7f9ed22f1a431c9cef97cd82022b8454954102
>>>>>>> 5f5cac5326938618709759d14757778d0bd916b2
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($patientId)
    {
        $patient = Patient::find($patientId);
        if (!$patient) {
            return response()->json(['message' => 'Patient not found'], 404);
        }
        $base = new BaseController();
        return $base->sendResponse($patient, 'Patient Detail of ID ' . $patient->id);
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(patient $patient)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, patient $patient)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'ssn' => 'required',
            'gender' => 'required',
            'phone_no' => 'required',
<<<<<<< HEAD
=======
<<<<<<< HEAD
=======
            'phone_no' => 'required',
>>>>>>> 1c7f9ed22f1a431c9cef97cd82022b8454954102
>>>>>>> 5f5cac5326938618709759d14757778d0bd916b2
        ]);
        $base = new BaseController();

        try {
            $currentMonth = Carbon::now()->format('m');
            $totalPatient = patient::whereMonth('created_at', $currentMonth)->count();
            $count_one = 1;
            $countPatient = date('ym') . $totalPatient + $count_one;
            $patient = patient::find($request->id);
            if ($patient != NULL) {
                $patient->title = $request->title;
                $patient->first_name = $request->first_name;
                $patient->middle_name = $request->middle_name;
                $patient->last_name = $request->last_name;
                $patient->nick_name = $request->nick_name;
                $patient->phone_no = $request->phone_no;
                $patient->email = $request->email;
                $patient->suffix = $request->suffix;
                $patient->ssn = $request->ssn;
                $patient->gender = $request->gender;
                $patient->date_of_birth = $request->date_of_birth;
                $patient->general_identity = $request->general_identity;
                $patient->other = $request->other;
                $patient->location = $request->location;
                $patient->pharmacy = $request->pharmacy;
                $patient->address_1 = $request->address_1;
                $patient->address_2 = $request->address_2;
                $patient->city = $request->city;
                $patient->state = $request->state;
                $patient->zip_code = $request->zip_code;
                $patient->country = $request->country;
                $patient->save();
                $data['patient_id'] = $patient->id;
                return $base->sendResponse($data, 'Patient Updated Successfully');
            } else {
                return $base->sendError('No Patient Found');
            }
        } catch (\Exception $e) {
            return $base->sendError($e->getMessage());
<<<<<<< HEAD
=======
<<<<<<< HEAD
=======

        try {
            $currentMonth = Carbon::now()->format('m');
            $totalPatient = patient::whereMonth('created_at', $currentMonth)->count();
            $count_one = 1;
            $countPatient = date('ym') . $totalPatient + $count_one;
            $patient = patient::find($request->id);
            if ($patient != NULL) {
                $patient->title = $request->title;
                $patient->first_name = $request->first_name;
                $patient->middle_name = $request->middle_name;
                $patient->last_name = $request->last_name;
                $patient->nick_name = $request->nick_name;
                $patient->phone_no = $request->phone_no;
                $patient->email = $request->email;
                $patient->suffix = $request->suffix;
                $patient->ssn = $request->ssn;
                $patient->gender = $request->gender;
                $patient->date_of_birth = $request->date_of_birth;
                $patient->general_identity = $request->general_identity;
                $patient->other = $request->other;
                $patient->location = $request->location;
                $patient->pharmacy = $request->pharmacy;
                $patient->address_1 = $request->address_1;
                $patient->address_2 = $request->address_2;
                $patient->city = $request->city;
                $patient->state = $request->state;
                $patient->zip_code = $request->zip_code;
                $patient->country = $request->country;
                $patient->save();
                $data['patient_id'] = $patient->id;
                return $base->sendResponse($data, 'Patient Updated Successfully');
            } else {
                return $base->sendError('No Patient Found');
            }
        } catch (\Exception $e) {
            return $base->sendError($e->getMessage());
>>>>>>> 1c7f9ed22f1a431c9cef97cd82022b8454954102
>>>>>>> 5f5cac5326938618709759d14757778d0bd916b2
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(patient $patient)
    {
        $base = new BaseController();
        $patient->delete();
        return $base->sendResponse([], 'Patient deleted successfully');
    }

    public function summary_patient($id)
    {
        $patient = Patient::find($id);
        if (!$patient) {
            return response()->json(['message' => 'Patient not found'], 404);
        }

        $data = [
            'patient' => $patient,
            'problems' => Problem::where('patient_id', $id)->orderBy('created_at', 'DESC')->get(),
            'contacts' => Contact::where('patient_id', $id)->orderBy('created_at', 'DESC')->get(),
            'medications' => Medication::where('patient_id', $id)->get()
        ];

        return response()->json($data, 200);
    }
<<<<<<< HEAD
=======
<<<<<<< HEAD
=======

    public function summary_patient($id)
    {
        $patient = Patient::find($id);
        if (!$patient) {
            return response()->json(['message' => 'Patient not found'], 404);
        }

        $data = [
            'patient' => $patient,
            'problems' => Problem::where('patient_id', $id)->orderBy('created_at', 'DESC')->get(),
            'contacts' => Contact::where('patient_id', $id)->orderBy('created_at', 'DESC')->get(),
            'medications' => Medication::where('patient_id', $id)->get()
        ];

        return response()->json($data, 200);
    }
>>>>>>> 1c7f9ed22f1a431c9cef97cd82022b8454954102
>>>>>>> 5f5cac5326938618709759d14757778d0bd916b2
}
