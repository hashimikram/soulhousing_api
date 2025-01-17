<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Api\BaseController as BaseController;
use App\Models\AdmissionDischarge;
use App\Models\Allergy;
use App\Models\bed;
use App\Models\Contact;
use App\Models\medication;
use App\Models\patient;
use App\Models\PatientEncounter;
use App\Models\Permission;
use App\Models\Problem;
use App\Models\Role;
use App\Models\RoleUser;
use App\Models\State;
use App\Models\User;
use App\Models\WebsiteSetting;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use RuntimeException;

class PatientController extends BaseController
{
    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        Log::info(current_facility(auth()->user()->id));
        try {
            // Query to fetch patients with the admissions table joined
            $patients = Patient::with([
                'problems',
                'admission',
                'allergies',
                'medications',
                'insurance',
                'room.floor',
                'role.role.permissions'
            ])
                ->where('patients.facility_id', current_facility(auth()->user()->id))
                ->where('patients.status', '!=', '0')
                ->join('admission_discharges', 'patients.id', '=', 'admission_discharges.patient_id')
                ->orderBy('admission_discharges.admission_date', 'DESC')
                ->select('patients.*')
                ->get();


            foreach ($patients as $patient) {
                $this->processPatientData($patient);
                $settings = WebsiteSetting::whereIn('key', ['platform_name', 'platform_address', 'platform_contact'])->pluck('value', 'key');
                $patient->soul_housing_address = $settings['platform_address'] ?? '';
                $patient->soul_housing_phone = $settings['platform_contact'] ?? '';
                $patient->website = $settings['platform_name'] ?? '';
                $patient->provider_full_name = auth()->user()->details->title . ' ' . auth()->user()->name . ' ' . auth()->user()->details->last_name;
                $patient->provider_npi = auth()->user()->details->npi;
            }

            return response()->json([
                'success' => true,
                'data' => $patients
            ]);
        } catch (Exception $e) {
            Log::error('An error occurred in Patient Index: ' . $e->getMessage(), [
                'exception' => $e
            ]);

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while retrieving patient data. Please try again later.'
            ], 500);
        }
    }


    private function processPatientData($patient)
    {
        try {
            $patient->patient_full_name = $this->formatPatientFullName($patient);
            $patient->patient_bed_status = $this->bed_check($patient);

            $patient->age = Carbon::parse($patient->date_of_birth)->age;

            $patient->profile_pic = image_url($patient->profile_pic);

            $admission = AdmissionDischarge::where('patient_id', $patient->id)->first();

            $patient->admission_date = $admission ? $admission->admission_date : '';
            $patient->room_no = $admission ? $admission->room_no : '';
            $patient->floor_name = $patient->room->floor->floor_name ?? '';
            $patient->room_name = $patient->room->room_name ?? '';
            $patient->bed_title = $patient->bed->bed_title ?? '';
            $patient->patient_facility = $patient->facility->name ?? '';

            $patient->admission_date_result = $this->calculateAdmissionDateResult($admission);

            $patient->allergies = $patient->allergies;
            $patient->problems = $patient->problems;
            $patient->medications = $this->formatMedications($patient->id);

            $patient->role = $patient->role ? [
                'role_name' => $patient->role->role->role_name,
                'permissions' => $patient->role->role->permissions->map(function ($permission) {
                    return [
                        'permissions' => $permission->permissions,
                    ];
                })
            ] : null;
        } catch (Exception $e) {
            Log::error('An error occurred while processing patient data: ' . $e->getMessage(), [
                'patient_id' => $patient->id,
                'exception' => $e
            ]);
        }
    }

    private function formatPatientFullName($patient)
    {
        try {
            $parts = [];

            if (!empty($patient->last_name)) {
                $parts[] = $patient->last_name;
            }

            if (!empty($patient->first_name)) {
                $parts[] = $patient->first_name;
            }

            if (!empty($patient->middle_name)) {
                $parts[] = ucfirst(substr($patient->middle_name, 0, 1));
            }

            return implode(', ', $parts);
        } catch (Exception $e) {
            Log::error('An error occurred while formatting patient full name: ' . $e->getMessage(), [
                'patient_id' => $patient->id,
                'exception' => $e
            ]);

            return 'Unknown';
        }
    }

    public function bed_check($patient)
    {
        $bed = bed::where(['patient_id' => $patient->id, 'status' => 'hospitalized'])->first();
        if ($bed) {
            $status = 'hospitalized';
        } else {
            $status = NULL;
        }
        return $status;
    }

    private function calculateAdmissionDateResult($admission)
    {
        try {
            $formattedResult = [
                'color' => '',
                'exceeded_days' => '',
                'remaining_days' => '',
                'message' => ""
            ];

            if (!$admission) {
                return $formattedResult;
            }

            $admissionDate = Carbon::parse($admission->admission_date);
            $currentDate = Carbon::now();
            $daysDifference = $admissionDate->diffInDays($currentDate);

            if ($daysDifference > 90) {
                $daysBeyondNinety = $daysDifference - 90;
                $formattedResult = [
                    'color' => 'red',
                    'exceeded_days' => number_format($daysBeyondNinety, 0),
                    'remaining_days' => 0,
                    'message' => "Exceeded by $daysBeyondNinety days"
                ];
            } else {
                $remainingDays = 90 - $daysDifference;
                $formattedResult = [
                    'color' => 'green',
                    'exceeded_days' => 0,
                    'remaining_days' => number_format($remainingDays, 0),
                    'message' => "$remainingDays days remaining"
                ];
            }

            return $formattedResult;
        } catch (Exception $e) {
            Log::error('An error occurred while calculating admission date result: ' . $e->getMessage(), [
                'admission' => $admission,
                'exception' => $e
            ]);

            return [
                'color' => 'grey',
                'exceeded_days' => '',
                'remaining_days' => '',
                'message' => 'Error calculating result'
            ];
        }
    }

    private function formatMedications($patientId)
    {
        try {
            return medication::where('patient_id', $patientId)
                ->where('status', 'active')
                ->latest()
                ->get()
                ->map(function ($medication) {
                    $formatted = $medication->title;

                    if (!empty($medication->dose) && !empty($medication->unit)) {
                        $formatted .= ' - ' . $medication->dose . ' ' . $medication->unit;
                    }

                    if (!empty($medication->quantity)) {
                        $formatted .= ', ' . $medication->quantity;
                    }

                    if (!empty($medication->frequency)) {
                        $formatted .= ' (' . $medication->frequency . ')';
                    }

                    return $formatted;
                });
        } catch (Exception $e) {
            Log::error('An error occurred while formatting medications: ' . $e->getMessage(), [
                'patient_id' => $patientId,
                'exception' => $e
            ]);

            return [];
        }
    }

    public function my_patients()
    {
        Log::info(current_facility(auth()->user()->id));
        try {
            $patients = Patient::with([
                'problems',
                'admission',
                'allergies',
                'medications',
                'insurance',
                'room.floor',
                'role.role.permissions'
            ])
                ->where('provider_id', auth()->user()->id)
                ->where('facility_id', current_facility(auth()->user()->id))
                ->where('status', '!=', '0')
                ->orderBy('created_at', 'DESC')
                ->get();

            foreach ($patients as $patient) {
                $this->processPatientData($patient);
            }

            return response()->json([
                'success' => true,
                'data' => $patients
            ]);
        } catch (Exception $e) {
            Log::error('An error occurred in Patient Index: ' . $e->getMessage(), [
                'exception' => $e
            ]);

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while retrieving patient data. Please try again later.'
            ], 500);
        }
    }

    public function un_assigned_patients()
    {
        Log::info(current_facility(auth()->user()->id));
        try {
            $patients = Patient::with([
                'problems',
                'admission',
                'allergies',
                'medications',
                'insurance',
                'room.floor',
                'role.role.permissions'
            ])
                ->where('facility_id', current_facility(auth()->user()->id))
                ->where('status', '!=', '0')
                ->where('provider_id', null)
                ->orderBy('created_at', 'DESC')
                ->get();

            foreach ($patients as $patient) {
                $this->processPatientData($patient);
            }

            return response()->json([
                'success' => true,
                'data' => $patients
            ]);
        } catch (Exception $e) {
            Log::error('An error occurred in Patient Index: ' . $e->getMessage(), [
                'exception' => $e
            ]);

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while retrieving patient data. Please try again later.'
            ], 500);
        }
    }

    public function un_sign_patients()
    {
        Log::info(current_facility(auth()->user()->id));
        try {
            $patients = Patient::select('patients.*')
                ->leftJoin('patient_encounters', 'patients.id', '=', 'patient_encounters.patient_id')
                ->whereNull('patient_encounters.patient_id')
                ->with([
                    'problems',
                    'admission',
                    'allergies',
                    'medications',
                    'insurance',
                    'room.floor',
                    'role.role.permissions'
                ])
                ->where('facility_id', current_facility(auth()->user()->id))
                ->where('status', '!=', '0')
                ->orderBy('created_at', 'DESC')
                ->get();


            foreach ($patients as $patient) {
                $this->processPatientData($patient);
            }

            return response()->json([
                'success' => true,
                'data' => $patients
            ]);
        } catch (Exception $e) {
            Log::error('An error occurred in Patient Index: ' . $e->getMessage(), [
                'exception' => $e
            ]);

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while retrieving patient data. Please try again later.'
            ], 500);
        }
    }

    public function search($search_text)
    {
        try {
            // Make sure to pass the search text to the method
            $patients = $this->getPatientsSearchWithDetails($search_text);

            foreach ($patients as $patient) {
                $this->processPatientData($patient);
            }

            return response()->json([
                'success' => true,
                'data' => $patients
            ]);
        } catch (Exception $e) {
            Log::error('An error occurred in Patient Search: ' . $e->getMessage(), [
                'exception' => $e
            ]);

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while retrieving patient data. Please try again later.'
            ], 500);
        }
    }

    private function getPatientsSearchWithDetails($search_text)
    {
        try {
            // Ensure that the $search_text parameter is used in the query
            return Patient::leftJoin('problems', 'problems.patient_id', '=', 'patients.id')
                ->leftJoin('beds', 'beds.patient_id', '=', 'patients.id')
                ->leftJoin('rooms', 'beds.room_id', '=', 'rooms.id')
                ->leftJoin('floors', 'rooms.floor_id', '=', 'floors.id')
                ->leftJoin('insurances', 'insurances.patient_id', '=', 'patients.id')
                ->select(
                    'patients.*',
                    'problems.diagnosis as problem_name',
                    'floors.floor_name',
                    'rooms.room_name',
                    'beds.bed_no',
                    'insurances.group_name'
                )
                ->where(function ($query) use ($search_text) {
                    $query->where('patients.first_name', 'LIKE', '%' . $search_text . '%')
                        ->orWhere('patients.last_name', 'LIKE', '%' . $search_text . '%')
                        ->orWhere('patients.mrn_no', 'LIKE', '%' . $search_text . '%');
                })
                ->where('patients.facility_id', current_facility(auth()->user()->id))
                ->orderBy('patients.created_at', 'DESC')
                ->groupBy('patients.id')
                ->get();
        } catch (Exception $e) {
            Log::error('An error occurred while fetching patients: ' . $e->getMessage(), [
                'exception' => $e
            ]);

            throw new RuntimeException('Failed to retrieve patient details.');
        }
    }

    public function search_admin(Request $request)
    {
        $search_text = $request->get('query');
        $patients = patient::where(function ($query) use ($search_text) {
            $query->where('patients.first_name', 'LIKE', '%' . $search_text . '%')
                ->orWhere('patients.last_name', 'LIKE', '%' . $search_text . '%')
                ->orWhere('patients.mrn_no', 'LIKE', '%' . $search_text . '%');
        })->get();

        return response()->json($patients);
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
            return $base->sendResponse(null, 'No patients Found');
        } else {
            return $base->sendError('patients Already Exists');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'first_name' => 'required|string',
            'middle_name' => 'nullable|string',
            'last_name' => 'required|string',
            'social_security_no' => 'nullable|string',
            'medical_no' => 'required|string',
            'age' => 'nullable|string',
            'gender' => 'required|string',
            'date_of_birth' => 'required',
            'referral_source_1' => 'nullable|string',
            'financial_class' => 'nullable|string',
            'fin_class_name' => 'nullable|string',
            'doctor_name' => 'nullable|string',
            'auth' => 'nullable|string',
            'admit_date' => 'nullable|date',
            'disch_date' => 'nullable|date',
            'pre_admit_date' => 'nullable|date',
            'nursing_station' => 'nullable|string',
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
        Log::info($request->all());
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
                $patient->first_name = $request->first_name;
                $patient->middle_name = $request->middle_name;
                $patient->last_name = $request->last_name;
                $patient->social_security_no = $request->social_security_no;
                $patient->medical_no = $request->medical_no;
                $patient->age = $request->age;
                $patient->gender = $request->gender;
                $formattedDate = $request->date_of_birth;
                $cleanedDateString = preg_replace('/\s*\(.*?\)/', '', $formattedDate);
                $date = date('Y-m-d', strtotime($cleanedDateString));
                $patient->date_of_birth = $date;
                $patient->referral_source_1 = $request->referral_source_1;
                $patient->organization = $request->referral_organization;
                $patient->referral_company_name = $request->referral_company_name;
                $patient->referral_contact_name = $request->referral_contact_name;
                $patient->referral_contact_email = $request->referral_contact_email;
                $patient->referral_contact_no = $request->referral_contact_no;
                $patient->financial_class = $request->financial_class;
                $patient->fin_class_name = $request->fin_class_name;
                $patient->doctor_name = $request->doctor_name;
                $patient->admit_date = $request->admit_date;
                $patient->disch_date = $request->disch_date;
                $patient->pre_admit_date = $request->pre_admit_date;
                $patient->nursing_station = $request->nursing_station;
                $patient->email = $request->email;
                $patient->other_email = $request->other_email;
                $patient->other_contact_name = $request->other_contact_name;
                $patient->other_contact_address = $request->other_contact_address;
                $patient->other_contact_country = $request->other_contact_country;
                $patient->other_contact_city = $request->other_contact_city;
                $patient->other_contact_state = $request->other_contact_state;
                $patient->other_contact_phone_no = $request->other_contact_phone_no;
                $patient->other_contact_cell = $request->other_contact_cell;
                $patient->relationship = $request->relationship;
                $patient->medical_dependency = $request->medical_dependency;
                $patient->address = $request->contact_address;
                $patient->city = $request->city;
                $patient->state = $request->state;
                $patient->language = $request->language;
                $patient->phone_no = $request->phone_no;
                $patient->zip_code = $request->zip_code;
                $patient->country = $request->country;
                $patient->auth = $request->auth;
                $patient->npp = $request->npi;
                $patient->switch = $request->switch;
                $patient->facility_id = current_facility(auth()->user()->id) ?? null;
                // Check if media is provided
                if ($request->input('profile_pic')) {
                    Log::info('Image Found');
                    $fileData = $request->input('profile_pic');
                    if (preg_match('/^data:(\w+)\/(\w+);base64,/', $fileData, $type)) {
                        Log::info('64 Match');
                        $fileData = substr($fileData, strpos($fileData, ',') + 1);
                        $fileData = base64_decode($fileData);
                        $mimeType = strtolower($type[1]);
                        $extension = strtolower($type[2]);
                        $filename = uniqid() . '.' . $extension;
                        // Ensure the 'public/uploads' directory exists
                        $directory = public_path('uploads');
                        if (!file_exists($directory)) {
                            mkdir($directory, 0777, true);
                        }
                        // Save the file to the public/uploads directory
                        $filePath = $directory . '/' . $filename;
                        file_put_contents($filePath, $fileData);
                        $publicPath = asset('uploads/' . $filename);
                        Log::info($filename);
                        $patient->profile_pic = $filename;
                    } else {
                        $filename = "placeholder.jpg";
                        $patient->profile_pic = $filename;
                    }
                } else {
                    Log::info('Image Not Found');
                    $filename = "placeholder.jpg";
                    $patient->profile_pic = $filename;
                }

                $patient->save();
                $recentAdd = patient::find($patient->id);
                $countPatient = 'sk-' . str_pad($patient->id, 4, '0', STR_PAD_LEFT);
                $recentAdd->mrn_no = $countPatient;
                $recentAdd->save();
                $data['patient_id'] = $patient->id;
                return $base->sendResponse($data, 'patients Added Successfully');
            } catch (Exception $e) {
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
        $medications = medication::where('patient_id', $patientId)->where('status', 'active')->latest()->get();
        if (!$patient) {
            return response()->json(['message' => 'patients not found'], 404);
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
                $patient->first_name = $request->first_name;
                $patient->middle_name = $request->middle_name;
                $patient->last_name = $request->last_name;
                $patient->social_security_no = $request->social_security_no;
                $patient->medical_no = $request->medical_no;
                $patient->age = $request->age;
                $patient->gender = $request->gender;
                $formattedDate = $request->date_of_birth;
                $cleanedDateString = preg_replace('/\s*\(.*?\)/', '', $formattedDate);
                $date = date('Y-m-d', strtotime($cleanedDateString));
                $patient->date_of_birth = $date;
                $patient->referral_source_1 = $request->referral_source_1;
                $patient->organization = $request->referral_organization;
                $patient->referral_company_name = $request->referral_company_name;
                $patient->referral_contact_name = $request->referral_contact_name;
                $patient->referral_contact_email = $request->referral_contact_email;
                $patient->referral_contact_no = $request->referral_contact_no;
                $patient->financial_class = $request->financial_class;
                $patient->fin_class_name = $request->fin_class_name;
                $patient->doctor_name = $request->doctor_name;
                $patient->admit_date = $request->admit_date;
                $patient->disch_date = $request->disch_date;
                $patient->pre_admit_date = $request->pre_admit_date;
                $patient->email = $request->email;
                $patient->other_email = $request->other_email;
                $patient->other_contact_name = $request->other_contact_name;
                $patient->other_contact_address = $request->other_contact_address;
                $patient->other_contact_country = $request->other_contact_country;
                $patient->other_contact_city = $request->other_contact_city;
                $patient->other_contact_state = $request->other_contact_state;
                $patient->other_contact_phone_no = $request->other_contact_phone_no;
                $patient->other_contact_cell = $request->other_contact_cell;
                $patient->relationship = $request->relationship;
                $patient->medical_dependency = $request->medical_dependency;
                $patient->address = $request->contact_address;
                $patient->city = $request->city;
                $patient->state = $request->state;
                $patient->auth = $request->auth;
                $patient->npp = $request->npi;
                $patient->language = $request->language;
                $patient->phone_no = $request->phone_no;
                $patient->zip_code = $request->zip_code;
                $patient->country = $request->country;
                $patient->switch = $request->switch;
                $oldFilePath = null;
                // Check if media is provided
                if ($request->input('profile_pic')) {
                    Log::info('Image Found');
                    $fileData = $request->input('profile_pic');
                    if (preg_match('/^data:(\w+)\/(\w+);base64,/', $fileData, $type)) {
                        Log::info('64 Match');
                        $fileData = substr($fileData, strpos($fileData, ',') + 1);
                        $fileData = base64_decode($fileData);
                        $mimeType = strtolower($type[1]);
                        $extension = strtolower($type[2]);
                        $filename = uniqid() . '.' . $extension;
                        // Ensure the 'public/uploads' directory exists
                        $directory = public_path('uploads');
                        if (!file_exists($directory)) {
                            mkdir($directory, 0777, true);
                        }
                        // Save the file to the public/uploads directory
                        $filePath = $directory . '/' . $filename;
                        file_put_contents($filePath, $fileData);
                        $publicPath = asset('uploads/' . $filename);
                        Log::info($filename);
                        $patient->profile_pic = $filename;
                    } else {
                        Log::info('64 Not Match');
                    }
                }

                $patient->save();
                $data['patient_id'] = $patient->id;
                return $base->sendResponse($data, 'patients Updated Successfully');
            } else {
                return $base->sendError('No patients Found');
            }
        } catch (Exception $e) {
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
        return $base->sendResponse([], 'patients deleted successfully');
    }

    public function summary_patient($id)
    {
        $patient = Patient::find($id);
        if (!$patient) {
            return response()->json(['message' => 'patients not found'], 404);
        }
        $patient->patient_full_name = $patient->first_name . ' ' . $patient->last_name;

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

        $admission_patient = AdmissionDischarge::join(
            'facilities',
            'facilities.id',
            '=',
            'admission_discharges.admission_location'
        )->select(
            'facilities.name as location',
            'admission_discharges.*'
        )->where(
            'admission_discharges.patient_id',
            $id
        )->where('admission_discharges.status', '1')
            ->first();
        if ($admission_patient) {
            $admission_patient->admission_date = $admission_patient->admission_date;
        } else {
        }


        if ($admission_patient) {
            $formattedResult = [
                'color' => '',
                'exceeded_days' => '',
                'remaining_days' => '',
                'message' => ""
            ];
            $admission_patient->admission_date_result = $formattedResult;
            $admission_patient->room_no = $admission_patient ? $admission_patient->room_no : '';
            // Parse the admission date
            $admissionDate = Carbon::parse($admission_patient->admission_date);

            // Get the current date
            $currentDate = Carbon::now();
            // Calculate the difference in days between the current date and the admission date
            $daysDifference = $admissionDate->diffInDays($currentDate);
            Log::info('Days Difference: ' . $daysDifference);

            // Check if the days difference is greater than 90
            if ($daysDifference > 90) {
                $daysBeyondNinety = $daysDifference - 90;
                $formattedResult = [
                    'color' => 'red',
                    'exceeded_days' => number_format($daysBeyondNinety, 0),
                    'remaining_days' => 0,
                    'message' => "Exceeded by $daysBeyondNinety days"
                ];
            } else {
                $remainingDays = 90 - $daysDifference;
                $formattedResult = [
                    'color' => 'green',
                    'exceeded_days' => 0,
                    'remaining_days' => number_format($remainingDays, 0),
                    'message' => "$remainingDays days remaining"
                ];
            }

            // Assign the result to the admission_date_result property
            $admission_patient->admission_date_result = $formattedResult;
        }
        $encounter = PatientEncounter::leftjoin(
            'list_options as encounter_type',
            'encounter_type.id',
            '=',
            'patient_encounters.encounter_type'
        )
            ->leftjoin('list_options as specialty', 'specialty.id', '=', 'patient_encounters.specialty')
            ->leftjoin('users as provider', 'provider.id', '=', 'patient_encounters.provider_id_patient')
            ->leftjoin('patients', 'patients.id', '=', 'patient_encounters.patient_id')
            ->leftjoin('facilities', 'facilities.id', '=', 'patient_encounters.location')
            ->select(
                'patient_encounters.*',
                'facilities.name as location',
                'encounter_type.title as encounter_type_title',
                'specialty.title as specialty_title',
                'provider.name as provider_name',
                'patients.mrn_no',
                DB::raw("CONCAT(patients.first_name, ' ', patients.last_name) AS patient_full_name"),
                'patients.date_of_birth',
                'patients.gender',
                'patient_encounters.pdf_make'
            )
            ->where('patient_encounters.patient_id', $id)
            ->latest()
            ->first() ?? [];

        $medication = medication::where('patient_id', $id)->get();
        foreach ($medication as $medication_data) {
            $formatted_data = $medication_data->title;

            if (!empty($medication_data->dose) && !empty($medication_data->unit)) {
                $medication_data->dose = ' - ' . $medication_data->dose . ' ' . $medication_data->unit;
            }

            if (!empty($medication_data->quantity)) {
                $medication_data->quantity = ', ' . $medication_data->quantity;
            }

            if (!empty($medication_data->frequency)) {
                $medication_data->frequency = ' (' . $medication_data->frequency . ')';
            }
        }
        $data = [
            'patient' => $patient,
            'problems' => $problems,
            'admissions' => $admission_patient ?? [],
            'contacts' => Contact::where('patient_id', $id)->orderBy('created_at', 'DESC')->get(),
            'medications' => $medication,
            'encounters' => $encounter,
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

    public function blacklist_patient(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id'
        ]);
        try {
            $patient = patient::findOrFail($request->patient_id);
            if ($patient) {
                $patient->status = '0';
                $patient->save();
                return response()->json([
                    'status' => true,
                    'message' => 'Patient Blacklist Successfully',
                ], 200);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Patient Not Found',
                ], 202);
            }
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ], 202);
        }
    }

    public function getUpdatedPatientDetails($patient_id)
    {
        try {
            $patient = patient::findOrFail($patient_id);
            $this->processPatientData($patient);
            return response()->json([
                'status' => true,
                'patient' => $patient,
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    private function getRoleAndPermissions($patientId)
    {
        try {
            $roleUser = RoleUser::where('user_id', $patientId)->first();

            if (!$roleUser) {
                return null;
            }

            $role = Role::find($roleUser->role_id);
            $permissions = Permission::where('role_id', $roleUser->role_id)->get();

            return [
                'role_name' => $role->role_name,
                'permissions' => $permissions->map(function ($permission) {
                    return [
                        'permissions' => $permission->permissions,
                    ];
                })
            ];
        } catch (Exception $e) {
            Log::error('An error occurred while getting role and permissions: ' . $e->getMessage(), [
                'patient_id' => $patientId,
                'exception' => $e
            ]);

            return null;
        }
    }

    private function getPatientsWithDetails()
    {
        try {
            return Patient::leftJoin('problems', 'problems.patient_id', '=', 'patients.id')
                ->leftJoin('beds', 'beds.patient_id', '=', 'patients.id')
                ->leftJoin('rooms', 'beds.room_id', '=', 'rooms.id')
                ->leftJoin('floors', 'rooms.floor_id', '=', 'floors.id')
                ->leftJoin('insurances', 'insurances.patient_id', '=', 'patients.id')
                ->select(
                    'patients.*',
                    'problems.diagnosis as problem_name',
                    'floors.floor_name',
                    'rooms.room_name',
                    'beds.bed_no',
                    'insurances.group_name'
                )
                ->where('patients.facility_id', auth()->user()->details->facilities)
                ->orderBy('patients.created_at', 'DESC')
                ->groupBy('patients.id')
                ->get();
        } catch (Exception $e) {
            Log::error('An error occurred while fetching patients: ' . $e->getMessage(), [
                'exception' => $e
            ]);

            throw new RuntimeException('Failed to retrieve patient details.');
        }
    }
}
