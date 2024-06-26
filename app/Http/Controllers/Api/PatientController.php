<?php

namespace App\Http\Controllers\Api;


use Carbon\Carbon;
use App\Models\Contact;
use App\Models\patient;
use App\Models\Problem;
use App\Models\medication;
use App\Models\State;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Api\BaseController as BaseController;
use App\Http\Requests\MedicationRequest;
use App\Models\Allergy;
use App\Models\PatientEncounter;

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
            ->groupBy('patients.id') // Ensure the group by clause is appropriate for your use case
            ->get();

        foreach ($patients as $data) {
            $data->patient_full_name = $data->first_name . ' ' . $data->last_name;
            $data->provider_full_name = auth()->user()->name;
            $data->admission_date = Carbon::now()->format('Y-m-d H:i A');
            $data->allergies = Allergy::where('patient_id', $data->id)->get();
            $data->problems = Problem::where('patient_id', $data->id)
                ->get()
                ->map(function ($problem) {
                    $problem->diagnosis = $problem->diagnosis;
                    return $problem;
                });
            $data->medications = Medication::where('patient_id', $data->id)->where('status', 'active')->latest()->get();
        }

        return response()->json([
            'success' => true,
            'data' => $patients
        ]);
    }


    public function search($search_text)
    {

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
            ->groupBy('patients.id') // Add 'patients.first_name' to the GROUP BY clause
            ->where('patients.provider_id', auth()->user()->id)
            ->get();
        foreach ($patients as $data) {
            $data->patient_full_name = $data->first_name . ' ' . $data->last_name;
            $data->provider_full_name = auth()->user()->name;
            $data->admission_date = Carbon::now()->format('Y-m-d H:i A');
            $data->patient_full_name = $data->first_name . ' ' . $data->last_name;
            $data->allergies = Allergy::where('patient_id', $data->id)->get();
            $data->problems = Problem::where('patient_id', $data->id)->get();
            $data->medications = Medication::where('patient_id', $data->id)->where('status', 'active')->latest()->get();
        }

        return response()->json([
            'success' => true,
            'data' => $patients
        ]);
    }

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
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'ssn' => 'required',
            'gender' => 'required',
            'email' => 'required|email',
            'phone_no' => 'required'
        ]);

        $base = new BaseController();
        $checkUnique = patient::where('first_name', $request->first_name)
            ->where('last_name', $request->last_name)
            ->where('gender', $request->gender)
            ->where('date_of_birth', $request->date_of_birth)
            ->first();
        if ($checkUnique == NULL) {
            try {
                $patient = new patient();
                $patient->provider_id = auth()->user()->id;
                $patient->title = $request->title;
                $patient->first_name = $request->first_name;
                $patient->middle_name = $request->middle_name;
                $patient->last_name = $request->last_name;
                $patient->nick_name = $request->nick_name;
                $patient->phone_no = $request->phone_no;
                $patient->email = $request->email;
                $patient->medical_no = $request->medical_no;
                $patient->medical_dependency = $request->medical_dependency;
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
                $data['patient_id'] = $patient->id;
                return $base->sendResponse($data, 'Patient Added Successfully');
            } catch (\Exception $e) {

                return $base->sendError($e->getMessage());
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

            return $base->sendError($existingPatientData);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($patientId)
    {
        $patient = Patient::find($patientId);
        $allergies = Allergy::where('patient_id', $patientId)->get();
        $problems = Problem::where('patient_id', $patientId)->get();
        $medications = Medication::where('patient_id', $patientId)->where('status', 'active')->latest()->get();
        if (!$patient) {
            return response()->json(['message' => 'Patient not found'], 404);
        }
        $base = new BaseController();
        return response()->json([
            'success' => true,
            'data' => $patient,
            'allergies' => $allergies,
            'medication' => $medications,
            'problems' => $problems,
        ]);
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
                $patient->medical_no = $request->medical_no;
                $patient->medical_dependency = $request->medical_dependency;
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

        $allergies = Allergy::with('allergy_type:id,list_id,title')
            ->where('patient_id', $id)
            ->latest()
            ->take(3)
            ->get()
            ->map(function ($allergy) {
                $allergy->allergy = $allergy->allergy;
                return $allergy;
            });

        $problems = Problem::where('patient_id', $id)
            ->latest()
            ->take(3)
            ->get()
            ->map(function ($problem) {
                $problem->diagnosis = $problem->diagnosis;
                return $problem;
            });

        $data = [
            'patient' => $patient,
            'problems' => $problems,
            'contacts' => Contact::where('patient_id', $id)->orderBy('created_at', 'DESC')->get(),
            'medications' => Medication::where('patient_id', $id)->get(),
            'encounters' => PatientEncounter::join('list_options as encounter_type', 'encounter_type.id', '=', 'patient_encounters.encounter_type')
                ->join('list_options as specialty', 'specialty.id', '=', 'patient_encounters.specialty')
                ->join('users as provider', 'provider.id', '=', 'patient_encounters.provider_id_patient')
                ->join('patients', 'patients.id', '=', 'patient_encounters.patient_id')
                ->select('patient_encounters.id', 'patient_encounters.provider_id', 'patient_encounters.provider_id_patient', 'patient_encounters.patient_id', 'patient_encounters.signed_by', 'patient_encounters.encounter_date', 'patient_encounters.parent_encounter', 'patient_encounters.location', 'patient_encounters.reason', 'patient_encounters.attachment', 'patient_encounters.status', 'patient_encounters.created_at', 'patient_encounters.updated_at', 'encounter_type.title as encounter_type_title', 'specialty.title as specialty_title', 'provider.name as provider_name', 'patients.mrn_no', DB::raw("CONCAT(patients.first_name, ' ', patients.last_name) AS patient_full_name"), 'patients.date_of_birth', 'patients.gender', 'patient_encounters.pdf_make')->where('patient_encounters.patient_id', $id)
                ->latest()->first(),
            'allergies' => $allergies,
        ];

        return response()->json($data, 200);
    }

    public function states()
    {
        $states = State::all();
        return response()->json($states, 200);
    }
}
