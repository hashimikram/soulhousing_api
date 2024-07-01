<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Api\BaseController as BaseController;
use App\Models\Allergy;
use App\Models\Contact;
use App\Models\medication;
use App\Models\patient;
use App\Models\PatientEncounter;
use App\Models\Problem;
use App\Models\State;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
            ->select('patients.*', 'problems.diagnosis as problem_name', 'floors.floor_name', 'rooms.room_name',
                'beds.bed_no', 'insurances.insurance_name')
            ->where('patients.provider_id', auth()->user()->id)
            ->orderBy('patients.created_at', 'DESC')
            ->groupBy('patients.id') // Ensure the group by clause is appropriate for your use case
            ->get();

        foreach ($patients as $data) {
            $data->patient_full_name = $data->first_name.' '.$data->last_name;
            $data->provider_full_name = auth()->user()->name;
            $data->profile_pic = image_url($data->profile_pic);
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
            ->select('patients.*', 'problems.diagnosis as problem_name', 'floors.floor_name', 'rooms.room_name',
                'beds.bed_no', 'insurances.insurance_name')
            ->where(function ($query) use ($search_text) {
                $query->where('first_name', 'LIKE', '%'.$search_text.'%')
                    ->orWhere('last_name', 'LIKE', '%'.$search_text.'%')
                    ->orWhere('mrn_no', 'LIKE', '%'.$search_text.'%');
            })
            ->orderBy('patients.created_at', 'DESC')
            ->groupBy('patients.id') // Add 'patients.first_name' to the GROUP BY clause
            ->where('patients.provider_id', auth()->user()->id)
            ->get();
        foreach ($patients as $data) {
            $data->patient_full_name = $data->first_name.' '.$data->last_name;
            $data->provider_full_name = auth()->user()->name;
            $data->admission_date = Carbon::now()->format('Y-m-d H:i A');
            $data->patient_full_name = $data->first_name.' '.$data->last_name;
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
            return $base->sendResponse(null, 'No Patient Found');
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
            'title' => 'nullable|string',
            'first_name' => 'required|string',
            'middle_name' => 'nullable|string',
            'last_name' => 'required|string',
            'social_security_no' => 'nullable|string',
            'medical_no' => 'nullable|string',
            'age' => 'nullable|string',
            'gender' => 'nullable|string',
            'date_of_birth' => 'nullable|date',
            'race' => 'nullable|string',
            'ethnicity' => 'nullable|string',
            'marital_status' => 'nullable|string',
            'referral_source_1' => 'nullable|string',
            'referral_source_2' => 'nullable|string',
            'financial_class' => 'nullable|string',
            'fin_class_name' => 'nullable|string',
            'doctor_name' => 'nullable|string',
            'auth' => 'nullable|string',
            'account_no' => 'nullable|string',
            'admit_date' => 'nullable|date',
            'disch_date' => 'nullable|date',
            'adm_dx' => 'nullable|string',
            'resid_military' => 'nullable|string',
            'pre_admit_date' => 'nullable|date',
            'service' => 'nullable|string',
            'nursing_station' => 'nullable|string',
            'occupation' => 'nullable|string',
            'employer' => 'nullable|string',
            'email' => 'nullable|string|email|unique:patients,email,id',
            'other_contact_name' => 'nullable|string',
            'other_contact_address' => 'nullable|string',
            'other_contact_country' => 'nullable|string',
            'other_contact_city' => 'nullable|string',
            'other_contact_state' => 'nullable|string',
            'other_contact_phone_no' => 'nullable|string',
            'other_contact_cell' => 'nullable|string',
            'relationship' => 'nullable|string',
            'medical_dependency' => 'nullable|string',
            'city' => 'nullable|string',
            'state' => 'nullable|string',
            'language' => 'nullable|string',
            'phone_no' => 'nullable|string',
            'zip_code' => 'nullable|string',
            'country' => 'nullable|string',
            'profile_pic' => 'nullable|string',
            'status' => 'nullable|string',
        ]);

        $base = new BaseController();
        $checkUnique = patient::where('first_name', $request->first_name)
            ->where('last_name', $request->last_name)
            ->where('gender', $request->gender)
            ->where('date_of_birth', $request->date_of_birth)
            ->first();
        if ($checkUnique == null) {
            try {
                $patient = new patient();
                $patient->provider_id = auth()->user()->id;
                $patient->title = $request->title;
                $patient->first_name = $request->first_name;
                $patient->middle_name = $request->middle_name;
                $patient->last_name = $request->last_name;
                $patient->social_security_no = $request->social_security_no;
                $patient->medical_no = $request->medical_no;
                $patient->age = $request->age;
                $patient->gender = $request->gender;
                $patient->date_of_birth = $request->date_of_birth;
                $patient->race = $request->race;
                $patient->ethnicity = $request->ethnicity;
                $patient->marital_status = $request->marital_status;
                $patient->referral_source_1 = $request->referral_source_1;
                $patient->referral_source_2 = $request->referral_source_2;
                $patient->financial_class = $request->financial_class;
                $patient->fin_class_name = $request->fin_class_name;
                $patient->doctor_name = $request->doctor_name;
                $patient->account_no = $request->account_no;
                $patient->admit_date = $request->admit_date;
                $patient->disch_date = $request->disch_date;
                $patient->adm_dx = $request->adm_dx;
                $patient->pre_admit_date = $request->pre_admit_date;
                $patient->service = $request->service;
                $patient->nursing_station = $request->nursing_station;
                $patient->occupation = $request->occupation;
                $patient->employer = $request->employer;
                $patient->email = $request->email;
                $patient->other_contact_name = $request->other_contact_name;
                $patient->other_contact_address = $request->other_contact_address;
                $patient->other_contact_country = $request->other_contact_country;
                $patient->other_contact_city = $request->other_contact_city;
                $patient->other_contact_state = $request->other_contact_state;
                $patient->other_contact_phone_no = $request->other_contact_phone_no;
                $patient->other_contact_cell = $request->other_contact_cell;
                $patient->relationship = $request->relationship;
                $patient->medical_dependency = $request->medical_dependency;
                $patient->city = $request->city;
                $patient->state = $request->state;
                $patient->language = $request->language;
                $patient->phone_no = $request->phone_no;
                $patient->zip_code = $request->zip_code;
                $patient->country = $request->country;
                // Check if media is provided
                if ($request->has('profile_pic')) {
                    $fileData = $request->input('profile_pic');
                    if (preg_match('/^data:(\w+)\/(\w+);base64,/', $fileData, $type)) {
                        $fileData = substr($fileData, strpos($fileData, ',') + 1);
                        $fileData = base64_decode($fileData);
                        if ($fileData === false) {
                            $filename = "placeholder.jpg";
                        }
                        $mimeType = strtolower($type[1]);
                        $extension = strtolower($type[2]);
                        $filename = uniqid().'.'.$extension;
                        // Ensure the 'public/uploads' directory exists
                        $directory = public_path('uploads');
                        if (!file_exists($directory)) {
                            mkdir($directory, 0777, true);
                        }
                        // Save the file to the public/uploads directory
                        $filePath = $directory.'/'.$filename;
                        file_put_contents($filePath, $fileData);
                        $publicPath = asset('uploads/'.$filename);
                    } else {
                        $filename = "placeholder.jpg";
                    }
                } else {
                    $filename = "placeholder.jpg";
                }
                $patient->profile_pic = $filename;
                $patient->save();
                $recentAdd = patient::find($patient->id);
                $countPatient = 'sk-'.str_pad($patient->id, 4, '0', STR_PAD_LEFT);
                $recentAdd->mrn_no = $countPatient;
                $recentAdd->save();
                $data['patient_id'] = $patient->id;
                return $base->sendResponse($data, 'Patient Added Successfully');
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage()
                ], 500);
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
            'id' => 'required|exists:patients,id',
        ]);
        $base = new BaseController();

        try {

            $patient = patient::find($request->id);
            if ($patient != null) {
                $patient->title = $request->title;
                $patient->first_name = $request->first_name;
                $patient->middle_name = $request->middle_name;
                $patient->last_name = $request->last_name;
                $patient->social_security_no = $request->social_security_no;
                $patient->medical_no = $request->medical_no;
                $patient->age = $request->age;
                $patient->gender = $request->gender;
                $patient->date_of_birth = $request->date_of_birth;
                $patient->race = $request->race;
                $patient->ethnicity = $request->ethnicity;
                $patient->marital_status = $request->marital_status;
                $patient->referral_source_1 = $request->referral_source_1;
                $patient->referral_source_2 = $request->referral_source_2;
                $patient->financial_class = $request->financial_class;
                $patient->fin_class_name = $request->fin_class_name;
                $patient->doctor_name = $request->doctor_name;
                $patient->account_no = $request->account_no;
                $patient->admit_date = $request->admit_date;
                $patient->disch_date = $request->disch_date;
                $patient->adm_dx = $request->adm_dx;
                $patient->pre_admit_date = $request->pre_admit_date;
                $patient->service = $request->service;
                $patient->nursing_station = $request->nursing_station;
                $patient->occupation = $request->occupation;
                $patient->employer = $request->employer;
                $patient->email = $request->email;
                $patient->other_contact_name = $request->other_contact_name;
                $patient->other_contact_address = $request->other_contact_address;
                $patient->other_contact_country = $request->other_contact_country;
                $patient->other_contact_city = $request->other_contact_city;
                $patient->other_contact_state = $request->other_contact_state;
                $patient->other_contact_phone_no = $request->other_contact_phone_no;
                $patient->other_contact_cell = $request->other_contact_cell;
                $patient->relationship = $request->relationship;
                $patient->medical_dependency = $request->medical_dependency;
                $patient->city = $request->city;
                $patient->state = $request->state;
                $patient->language = $request->language;
                $patient->phone_no = $request->phone_no;
                $patient->zip_code = $request->zip_code;
                $patient->country = $request->country;
                // Check if media is provided
                if ($request->has('profile_pic')) {
                    if ($patient->profile_pic != 'placeholder.jpg') {
                        $oldFilePath = public_path('uploads/'.$patient->profile_pic);
                        if (file_exists($oldFilePath)) {
                            unlink($oldFilePath);
                        }
                    }
                    $fileData = $request->input('profile_pic');
                    if (preg_match('/^data:(\w+)\/(\w+);base64,/', $fileData, $type)) {
                        $fileData = substr($fileData, strpos($fileData, ',') + 1);
                        $fileData = base64_decode($fileData);
                        if ($fileData === false) {
                            $filename = "placeholder.jpg";
                        }
                        $mimeType = strtolower($type[1]);
                        $extension = strtolower($type[2]);
                        $filename = uniqid().'.'.$extension;
                        // Ensure the 'public/uploads' directory exists
                        $directory = public_path('uploads');
                        if (!file_exists($directory)) {
                            mkdir($directory, 0777, true);
                        }
                        // Save the file to the public/uploads directory
                        $filePath = $directory.'/'.$filename;
                        file_put_contents($filePath, $fileData);
                        $publicPath = asset('uploads/'.$filename);
                    } else {
                        $filename = "placeholder.jpg";
                    }
                } else {
                    $filename = "placeholder.jpg";
                }


                $patient->profile_pic = $filename;
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
            'encounters' => PatientEncounter::join('list_options as encounter_type', 'encounter_type.id', '=',
                    'patient_encounters.encounter_type')
                    ->join('list_options as specialty', 'specialty.id', '=', 'patient_encounters.specialty')
                    ->join('users as provider', 'provider.id', '=', 'patient_encounters.provider_id_patient')
                    ->join('patients', 'patients.id', '=', 'patient_encounters.patient_id')
                    ->select('patient_encounters.id', 'patient_encounters.provider_id',
                        'patient_encounters.provider_id_patient', 'patient_encounters.patient_id',
                        'patient_encounters.signed_by', 'patient_encounters.encounter_date',
                        'patient_encounters.parent_encounter', 'patient_encounters.location',
                        'patient_encounters.reason', 'patient_encounters.attachment', 'patient_encounters.status',
                        'patient_encounters.created_at', 'patient_encounters.updated_at',
                        'encounter_type.title as encounter_type_title', 'specialty.title as specialty_title',
                        'provider.name as provider_name', 'patients.mrn_no',
                        DB::raw("CONCAT(patients.first_name, ' ', patients.last_name) AS patient_full_name"),
                        'patients.date_of_birth', 'patients.gender',
                        'patient_encounters.pdf_make')->where('patient_encounters.patient_id', $id)
                    ->latest()->first() ?? [],
            'allergies' => $allergies,
        ];

        return response()->json($data, 200);
    }

    public function states()
    {
        $states = State::all();
        return response()->json($states, 200);
    }

    public function all_providers()
    {
        $providers = User::where('user_type', 'provider')->get();
        return response()->json([
            'code' => true,
            'data' => $providers
        ], 200);
    }
}
