<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdmissionDischarge;
use App\Models\bed;
use App\Models\Facility;
use App\Models\floor;
use App\Models\patient;
use App\Models\room;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PatientController extends Controller
{
    public function index()
    {

        $patients = Patient::with([
            'provider',
            'problems',
            'admission',
            'allergies',
            'medications',
            'insurance',
            'room.floor',
            'role.role.permissions'
        ])->orderBy('created_at', 'desc')->where('status', '!=', '0')->paginate(10);
        return view('backend.pages.patients.index', compact('patients'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string',
            'gender' => 'required|string',
            'medical_number' => 'required|string',
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
                $patient->first_name = $request->first_name;
                $patient->middle_name = $request->middle_name;
                $patient->last_name = $request->last_name;
                $patient->social_security_no = $request->social_security_no;
                $patient->medical_no = $request->medical_number;
                $patient->age = Carbon::parse($request->date_of_birth)->age ?? null;
                $patient->gender = $request->gender;
                $patient->date_of_birth = $request->date_of_birth;
                $patient->authorization_no = $request->authorization_no;
                $patient->referral_source_1 = $request->referral_source_1;
                $patient->organization = $request->organization;
                $patient->referral_company_name = $request->referral_company_name;
                $patient->referral_contact_name = $request->referral_contact_name;
                $patient->referral_contact_email = $request->referral_contact_email;
                $patient->referral_contact_no = $request->referral_contact_no;
                $patient->financial_class = $request->financial_class;
                $patient->fin_class_name = $request->fin_class_name;
                $patient->doctor_name = $request->doctor_name;
                $patient->account_no = $request->account_no;
                $patient->admit_date = $request->admit_date;
                $patient->disch_date = $request->disch_date;
                $patient->pre_admit_date = $request->pre_admit_date;
                $patient->nursing_station = $request->nursing_station;
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
                $patient->address = $request->address;
                $patient->facility_id = $request->facility_id;
                if ($request->file('image')) {
                    $originalName = $request->file('image')->getClientOriginalName();
                    $imagePath = pathinfo(
                        $originalName,
                        PATHINFO_FILENAME
                    ) . '_' . time() . '.' . $request->file('image')->getClientOriginalExtension();
                    $destinationPath = public_path('uploads');
                    $request->file('image')->move($destinationPath, $imagePath);
                    $patient->profile_pic = $imagePath;
                } else {
                    $patient->profile_pic = 'placeholder.jpg';
                }
                $patient->save();
                $recentAdd = patient::find($patient->id);
                $countPatient = 'sk-' . str_pad($patient->id, 4, '0', STR_PAD_LEFT);
                $recentAdd->mrn_no = $countPatient;
                $recentAdd->save();
                return redirect()->route('patients.index')->with('success', 'Patient Add Successfully');
            } catch (Exception $e) {
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
            case 4:
                return Patient::orderBy('created_at', 'desc')->where('status', '0')->get();
            default:
                return collect();
        }
    }

    public function edit($id)
    {
        $patient = patient::FindOrFail($id);
        if (!isset($patient)) {
            return redirect()->route('patients.index')->with('error', 'Patient Not Found');
        }
        $facilities = Facility::all();
        return view('backend.pages.patients.edit', compact('patient', 'facilities'));
    }

    public function destroy($user_id)
    {
        $user = patient::FindOrFail($user_id);
        if (!isset($user)) {
            return redirect()->route('patients.index')->with('error', 'Patient Not Found');
        }
        $user->delete();
        return redirect()->route('patients.index')->with('success', 'Patient Deleted Successfully');
    }

    public function import(Request $request)
    {
        $data = [
            ['Robert', 'Williams', '11/24/1953', '95303890A', '1', '1', '1', '7/2/2024'],
            ['Igor', 'Goncharov', '2/28/1962', '93902263G', '1', '1', '2', '2/28/2023'],
            ['Andre', 'Borrego', '11/23/1977', '97512948E', '1', '1', '3', '3/26/2024'],
            ['Preston', 'Miles', '3/22/1994', '96390957A', '1', '2', '1', '7/1/2024'],
            ['', '', '', '', '1', '2', '2', ''],
            ['Lavondale', 'Hawkins', '2/25/1994', '97088466D', '1', '2', '3', '5/20/2024'],
            ['Jose', 'Macias', '3/7/1966', '94190109C', '1', '3', '1', '8/1/2024'],
            ['Carl', 'Gilmore', '2/15/1991', '92982298C', '1', '3', '2', '5/20/2024'],
            ['Omar', 'Merino', '12/12/1996', '99911511H', '1', '3', '3', '6/11/2024'],
            ['Anthony', 'Jackson', '9/20/1994', '93611580G', '1', '4', '1', '7/1/2024'],
            ['Lafarique', 'Johnson', '1/24/1993', '97584152D', '1', '4', '2', '7/3/2024'],
            ['Eddie', 'Malvo', '8/18/1966', '97540952C', '1', '4', '3', '5/14/2024'],
            ['Jahkeel', 'Ballinger', '4/15/1994', '96563540A', '1', '5', '1', '8/1/2024'],
            ['Travaughn', 'Jelks', '11/28/1981', '92800848A', '1', '5', '2', '6/4/2024'],
            ['William', 'Barnett', '1/10/1992', '96398494A', '1', '5', '3', '7/10/2024'],
            ['Libejoll', 'De La Torre', '4/12/1971', '91131602H', '1', '6', '1', '7/8/2024'],
            ['Juan', 'Lopez', '10/7/1974', '93554826C', '1', '6', '2', '3/21/2023'],
            ['Richard', 'Burgos', '11/28/1971', '91024280A', '1', '6', '3', '8/7/2024'],
            ['Don', 'Price', '9/2/1966', '93792102C', '1', '7', '1', '7/17/2024'],
            ['Marco', 'Loreto', '2/14/1972', '93342482C', '1', '7', '2', '5/22/2024'],
            ['Michael', 'Steele', '8/22/1991', '94382910A', '1', '8', '1', '1/8/2024'],
            ['John', 'Washington', '6/15/1982', '91972825A', '1', '8', '2', '11/14/2023'],
            ['Milthon', 'Alverado', '10/5/1993', '95205366A', '1', '8', '3', '3/21/2024'],
            ['Jermaine', 'Marbuery', '9/2/1966', '92862097A', '2', '9', '1', '7/23/2024'],
            ['Isidro', 'Ramirez', '8/21/1974', '95238175C', '2', '9', '2', '7/2/2024'],
            ['Dwayne', 'Moore', '93204254D', '11/30/1964', '2', '9', '3', '8/20/2024'],
            ['Jeffrey', 'Wilson', '7/15/1985', '96231026C', '2', '10', '1', '12/4/2023'],
            ['Joe', 'Marquez', '3/7/1979', '95995774A', '2', '10', '2', '12/28/2023'],
            ['Juan', 'Escamilla', '11/18/1997', '96590392D', '2', '10', '3', '4/4/2024'],
            ['Lionel', 'Anderson', '2/11/1980', '99349742H', '2', '11', '1', '6/6/2024'],
            ['', '', '', '', '2', '11', '2', ''],
            ['Luis', 'Santizo', '1/17/1980', '95860140E', '2', '11', '3', '5/20/2024'],
            ['Steven', 'Horn', '6/12/1962', '90234017A', '2', '12', '1', '8/21/2024'],
            ['Desmond', 'Guerero', '3/23/1981', '91172304C', '2', '12', '2', '5/20/2024'],
            ['Ronald', 'Frank', '10/4/1981', '95601498A', '2', '12', '3', '8/13/2024'],
            ['Francisco', 'Mendita', '3/15/1959', '99207009F', '2', '13', '1', '5/23/2024'],
            ['', '', '', '', '2', '13', '2', ''],
            ['Devin', 'Johnson', '1/12/1989', '98524117E', '2', '13', '3', '4/30/2024'],
            ['Omar', 'Espinoza', '9/27/1971', '93254587F', '2', '14', '1', '12/5/2023'],
            ['Roberto', 'Vallejo', '2/26/1971', '97269552C2', '2', '14', '2', '5/21/2024'],
            ['Edwin', 'Cooper', '7/25/1968', '90102921C', '2', '14', '3', '3/5/2024'],
            ['Christopher', 'Moore', '7/4/1994', '93813998C', '2', '15', '1', '3/20/2024'],
            ['Clifford', 'Arnold', '5/4/1985', '91665977A', '2', '15', '2', '5/6/2024'],
            ['Juan', 'Calmo', '7/24/1989', '94052208A', '2', '15', '3', '7/2/2024'],
            ['Charles', 'Queen', '8/9/1985', '92488203A', '2', '16', '1', '5/7/2024'],
            ['Roger', 'Bettencourt', '5/27/1952', '91555823F', '2', '16', '2', '5/17/2024'],
            ['Maurice', 'Rodgers', '4/7/1983', '91318738A', '2', '16', '3', '7/22/2024'],
            ['Miguel', 'Talancon', '5/10/1996', '96012081D', '2', '17', '1', '7/9/2024'],
            ['Stuart', 'Morales', '11/24/1967', '91362346A', '2', '17', '2', '12/7/2023'],
            ['Francisco', 'Cervantes', '6/20/1976', '91958982A', '2', '17', '3', '7/22/2024'],
            ['Anthony', 'Maulding', '12/29/1987', '93662271A', '2', '17', '4', '3/21/2024'],
            ['Grahame', 'Roberts', '8/6/1966', '90706479F', '2', '17', '5', '4/8/2024'],
            ['Alfredo', 'Aceves', '4/26/1998', '93813303D', '2', '17', '6', '12/27/2023'],
            ['Donta', 'Emmons', '9/29/1994', '95560049C', '2', '17', '7', '4/8/2024'],
        ];
        foreach ($data as $patientData) {
            try {
                $floorName = $patientData[4] ?? null;
                $roomName = $patientData[5] ?? null;
                $bedName = $patientData[6] ?? null;
                $facilityId = '1';

                $floor = Floor::firstOrCreate(
                    ['floor_name' => $floorName, 'facility_id' => $facilityId]
                );

                $room = Room::firstOrCreate(
                    ['room_name' => $roomName, 'floor_id' => $floor->id]
                );

                $bed = Bed::firstOrCreate(
                    ['bed_title' => $bedName, 'room_id' => $room->id, 'status' => 'vacant']
                );

                $first_name = $patientData[0] ?? null;
                $last_name = $patientData[1] ?? null;
                $date_of_birth = $patientData[2] ?? null;
                $medicalId = $patientData[3] ?? null;
                $admission_date = $patientData[7] ?? null;
                $patient = Patient::where('first_name', $first_name)
                    ->where('last_name', $last_name)
                    ->first();

                if ($date_of_birth) {
                    try {
                        $dob = Carbon::createFromFormat('m/d/Y', $date_of_birth);
                        $age = $dob->age;
                    } catch (Exception $e) {
                        // Handle the date parsing error
                        Log::error("Invalid date format for date_of_birth: $date_of_birth");
                        continue; // Skip this iteration
                    }
                } else {
                    $dob = null;
                    $age = null;
                }

                if ($admission_date) {
                    try {
                        $admission_date = Carbon::createFromFormat('m/d/Y', $admission_date);
                    } catch (Exception $e) {
                        Log::error("Invalid date format for admission_date: $admission_date");
                        continue;
                    }
                } else {
                    $admission_date = null;
                }

                if (!$patient) {
                    $patient = Patient::create([
                        'first_name' => $first_name,
                        'last_name' => $last_name,
                        'date_of_birth' => $dob,
                        'age' => $age,
                        'facility_id' => $facilityId,
                        'medical_no' => $medicalId,
                    ]);

                    $bed->patient_id = $patient->id;
                    $bed->status = 'occupied';
                    $bed->occupied_from = now();
                    $bed->booked_till = Carbon::now()->addDays(90);
                    $bed->save();

                    if ($admission_date) {
                        AdmissionDischarge::create([
                            'patient_id' => $patient->id,
                            'bed_id' => $bed->id,
                            'admission_date' => $admission_date,
                        ]);
                    }
                }
            } catch (Exception $e) {
                Log::error("Error processing patient data: " . json_encode($patientData) . " Error: " . $e->getMessage());
            }
        }
    }

    public function create()
    {
        $facilities = Facility::all();
        return view('backend.pages.patients.create', compact('facilities'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'first_name' => 'required|string',
            'gender' => 'required|string',
            'medical_number' => 'required|string',
        ]);
        $patient = patient::FindOrFail($id);
        if (!isset($patient)) {
            return redirect()->route('patients.index')->with('error', 'Patient Not Found');
        }

        try {
            $patient->provider_id = $request->provider_id;
            $patient->first_name = $request->first_name;
            $patient->middle_name = $request->middle_name;
            $patient->last_name = $request->last_name;
            $patient->social_security_no = $request->social_security_no;
            $patient->medical_no = $request->medical_number;
            $patient->age = Carbon::parse($request->date_of_birth)->age;
            $patient->gender = $request->gender;
            $patient->date_of_birth = $request->date_of_birth;
            $patient->authorization_no = $request->authorization_no;
            $patient->referral_source_1 = $request->referral_source_1;
            $patient->organization = $request->organization;
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
            $patient->address = $request->address;
            if ($request->file('image')) {
                $originalName = $request->file('image')->getClientOriginalName();
                $imagePath = pathinfo(
                    $originalName,
                    PATHINFO_FILENAME
                ) . '_' . time() . '.' . $request->file('image')->getClientOriginalExtension();
                $destinationPath = public_path('uploads');
                $request->file('image')->move($destinationPath, $imagePath);
                $patient->profile_pic = $imagePath;
            } else {
                $patient->profile_pic = 'placeholder.jpg';
            }
            $patient->save();
            $recentAdd = patient::find($patient->id);
            $countPatient = 'sk-' . str_pad($patient->id, 4, '0', STR_PAD_LEFT);
            $recentAdd->mrn_no = $countPatient;
            $recentAdd->save();
            return redirect()->route('patients.index')->with('success', 'Patient Add Successfully');
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
