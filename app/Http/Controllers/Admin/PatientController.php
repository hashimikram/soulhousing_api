<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\patient;
use App\Models\User;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    public function index()
    {
        $patients = Patient::orderBy('created_at', 'desc')->paginate(10);
        return view('backend.pages.patients.index', compact('patients'));
    }

    public function create()
    {
        $providers = User::where('user_type', 'provider')->get();
        return view('backend.pages.patients.create', compact('providers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'first_name' => 'required|string',
            'gender' => 'required|string',
            'marital_status' => 'required|string',
        ]);
        $checkUnique = patient::where('first_name', $request->first_name)
            ->where('last_name', $request->last_name)
            ->where('gender', $request->gender)
            ->where('date_of_birth', $request->date_of_birth)
            ->first();
        if ($checkUnique == null) {
            try {
                $patient = new patient();
                $patient->provider_id = $request->provider_id;
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
                if ($request->file('profile_pic')) {
                    $originalName = $request->file('profile_pic')->getClientOriginalName();
                    $imagePath = pathinfo($originalName,
                            PATHINFO_FILENAME).'_'.time().'.'.$request->file('profile_pic')->getClientOriginalExtension();
                    $destinationPath = public_path('uploads');
                    $request->file('profile_pic')->move($destinationPath, $imagePath);
                    $patient->profile_pic = $imagePath;
                } else {
                    $patient->profile_pic = 'placeholder.jpg';

                }
                $patient->save();
                $recentAdd = patient::find($patient->id);
                $countPatient = 'sk-'.str_pad($patient->id, 4, '0', STR_PAD_LEFT);
                $recentAdd->mrn_no = $countPatient;
                $recentAdd->save();
                return redirect()->route('patients.index')->with('success', 'Patient Add Successfully');
            } catch (\Exception $e) {
                return redirect()->back()->with('error', $e->getMessage());
            }
        } else {
            return redirect()->back()->with('error', 'Patient Already Exits');
        }
    }

    public function fetchPatients($tabId)
    {

        $patients = $this->getPatientsByType($tabId);

        $html = view('backend.pages.partials.patient_table', compact('patients'))->render();

        return response()->json(['html' => $html]);
    }

    private function getPatientsByType($tabId)
    {
        switch ($tabId) {
            case 1:
                return Patient::orderBy('created_at', 'desc')->get();
            case 2:
                return Patient::orderBy('created_at', 'desc')->whereNull('provider_id')->get();
            case 3:
                return Patient::orderBy('created_at', 'desc')->whereNotNull('provider_id')->get();
            default:
                return collect(); // Return an empty collection instead of an array
        }
    }


}
