<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Str;
use App\Models\PhysicalExam;
use Illuminate\Http\Request;
use DB;
use App\Models\ReviewOfSystem;
use Illuminate\Support\Facades\Schema;
use App\Models\PatientEncounter;
use Illuminate\Support\Facades\Log;
use App\Models\EncounterNoteSection;
use Illuminate\Foundation\Auth\User;
use App\Http\Controllers\Api\BaseController as BaseController;
use App\Models\ListOption;
use PDO;

class PatientEncounterController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'encounter_type' => 'required|exists:list_options,id',
            'specialty' => 'required|exists:list_options,id',
            'parent_encounter' => 'nullable|exists:patient_encounters,id',
            'reason' => 'required',
        ]);
        try {
          $encounter = new PatientEncounter();
$encounter->patient_id = $request->patient_id;
$encounter->provider_id = auth()->user()->id;
$encounter->provider_id_patient = $request->provider_id_patient;
date_default_timezone_set('Asia/Karachi');
$start = date('Y-m-d h:i:s', strtotime($request->signed_at));
$encounter->encounter_date = $start;
$encounter->signed_by =  auth()->user()->id;
$encounter->encounter_type = $request->encounter_type;
$encounter->specialty = $request->specialty;
$encounter->parent_encounter = $request->parent_encounter;
$encounter->location = $request->location;
$encounter->status = '0';
$encounter->reason = $request->reason;
if ($request->hasFile('attachment')) {
    $file = $request->file('attachment');
    $fileName = date('YmdHi') . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
    // Debug the destination directory path
    $destinationPath = public_path('uploads');
    // Move the file to the destination directory
    $file->move($destinationPath, $fileName);
    $encounter->attachment = $fileName;
}

$encounter->save();

$sections = [
    "Chief Complaint",
    "History",
    "Medical History",
     "Surgical History",
    "Family History",
    "Social History",
    "Allergies",
       "Medications",
        "Review of Systems",
    "Vital Sign",
    "Physical Exam",
    "ASSESSMENTS/CARE PLAN",
    "Follow Up"
];

$newSections = []; // Array to store newly created sections data

foreach ($sections as $sectionTitle) {
    $sectionSlug = Str::slug($sectionTitle);

    $section = new EncounterNoteSection();
    $section->patient_id = $request->patient_id;
    $section->provider_id = auth()->user()->id;
    $section->encounter_id = $encounter->id;
    $section->section_title = $sectionTitle;
    if($sectionTitle == 'Review of Systems'){
        $section->section_text="Constitutional:  \n HEENT: \n CV: \n GI: \n GU: \n Musculoskeletal: \n Skin: \n Psychiatric: \n Endocrine: \n Physical exam: \n";
    }elseif($sectionTitle == 'Physical Exam'){
           $section->section_text="General Appearance: \n Head and Neck: \n Eyes: \n Ears: \n Nose: \n Mouth & Throat: \n Cardiovascular: \n Respiratory System: \n Abdomen: \n Musculoskeletal System: \n Neurological System: \n Genitourinary System: \n Psychosocial Assessment:";
    }else{

    }
    $section->section_slug = $sectionSlug;
    $section->save();
    $newSections[] = $section->toArray();
}

 foreach ($newSections as &$section) {
            $section['section_id'] = $section['id'];
            unset($section['id']);
        }


$data = PatientEncounter::where('patient_encounters.id', $encounter->id)->leftjoin('list_options as encounter_type', 'encounter_type.id', '=', 'patient_encounters.encounter_type')
    ->leftjoin('list_options as specialty', 'specialty.id', '=', 'patient_encounters.specialty')
    ->leftjoin('users as provider', 'provider.id', '=', 'patient_encounters.provider_id_patient')
    ->leftjoin('patients', 'patients.id', '=', 'patient_encounters.patient_id')
    ->select('patient_encounters.id',  'patient_encounters.encounter_date', 'patient_encounters.patient_id', 'encounter_type.title as encounter_type_title', 'specialty.title as specialty_title', 'provider.name as provider_name', 'patients.mrn_no', DB::raw("CONCAT(patients.first_name, ' ', patients.last_name) AS patient_full_name"), 'patients.date_of_birth', 'patients.gender')
    ->first();

return response()->json(['encounter_id' => $encounter->id,'encounter' => $data, 'new_sections' => $newSections], 201);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function encounter_notes_store(Request $request)
    {




        $validatedData = $request->validate([

            'sections' => 'required|array',

        ]);

        $patient_id = $request->patient_id;
        $encounter_id = $request->encounter_id;

        // Loop through each section in the request and update it
        foreach ($validatedData['sections'] as $sectionData) {
            $sectionSlug = Str::slug($sectionData['section_title']);

            // Find the existing section by patient ID, encounter ID, and section slug
            $existingSection = EncounterNoteSection::where('patient_id', $patient_id)
                ->where('encounter_id', $encounter_id)
                ->where('section_slug', $sectionSlug)
                ->first();

            if ($existingSection) {
                // If the section already exists, update its section_text
                $existingSection->update([
                    'section_text' => $sectionData['section_text']
                ]);
            } else {
                // If the section doesn't exist, create a new one
                $section = new EncounterNoteSection();
                $section->patient_id = $patient_id;
                $section->provider_id = auth()->user()->id;
                $section->encounter_id = $encounter_id;
                $section->section_title = $sectionData['section_title'];
                $section->section_slug = $sectionSlug;
                $section->section_text = $sectionData['section_text'];
                $section->sorting_order = 1; // Use sorting_order from payload
                $section->save();
            }
        }

        return response()->json(['message' => "Notes Updated Successfully"], 200);


    }

    /**
     * Display the specified resource.
     */
    public function show($patient_id)
    {

        $data = PatientEncounter::join('list_options as encounter_type', 'encounter_type.id', '=', 'patient_encounters.encounter_type')
            ->join('list_options as specialty', 'specialty.id', '=', 'patient_encounters.specialty')
            ->join('users as provider', 'provider.id', '=', 'patient_encounters.provider_id_patient')
            ->join('patients', 'patients.id', '=', 'patient_encounters.patient_id')
            ->select('patient_encounters.id', 'patient_encounters.provider_id', 'patient_encounters.provider_id_patient', 'patient_encounters.patient_id', 'patient_encounters.signed_by', 'patient_encounters.encounter_date', 'patient_encounters.parent_encounter', 'patient_encounters.location', 'patient_encounters.reason', 'patient_encounters.attachment', 'patient_encounters.status', 'patient_encounters.created_at', 'patient_encounters.updated_at', 'encounter_type.title as encounter_type_title', 'specialty.title as specialty_title', 'provider.name as provider_name', 'patients.mrn_no', DB::raw("CONCAT(patients.first_name, ' ', patients.last_name) AS patient_full_name"), 'patients.date_of_birth', 'patients.gender')
            ->where('patient_id', $patient_id)

            ->get();
        foreach ($data as $reason) {
            if ($reason->status == '0') {
                $reason->status = 'draft';
            } else {
                $reason->status = 'assign';
            }
        }

        $base = new BaseController();
        return $base->sendResponse($data, 'Patient Encounter Fetched');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function encounter_notes($encounter_id)
    {
        // Get encounter note sections
        $sections = EncounterNoteSection::where('encounter_id', $encounter_id)->orderBy('id','ASC')->get();

        $formattedData = [];
        foreach ($sections as $section) {
            $sectionText = null;
            if ($section->section_text !== null) {
                $decodedText = json_decode($section->section_text, true);
                if ($decodedText !== null) {
                    $sectionText = $decodedText;
                } else {
                    $sectionText = $section->section_text;
                }
            }
            $formattedData[] = [
                'section_id' => $section->id,
                'section_title' => $section->section_title,
                'section_slug' => $section->section_slug,
                'section_text' => $sectionText
            ];
        }
        $response = [
            'success' => true,
            'data' => $formattedData,
            'message' => 'Encounter note sections fetched successfully'
        ];

        return response()->json($response, 200);
    }




    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {

        try {
            // Extract JSON data from the request
            $data = $request->json()->all();
            $encounter = PatientEncounter::findOrFail($request->encounter_id);
            $encounter->update([
                'patient_id' => $data['patient_id'],
                'signed_at' => $data['signed_at'],
                'encounter_type' => $data['encounter_type'],
                'encounter_template' => $data['encounter_template'],
                'reason' => $data['reason'],
            ]);
            $includeFields = ['section_text', 'review_of_system', 'physical_exam'];
            foreach ($includeFields as $sectionTitle) {
                $sectionData = $data[$sectionTitle] ?? null;

                if ($sectionData === null) {
                    continue;
                }

                if (is_array($sectionData)) {
                    if ($sectionTitle === 'review_of_system' || $sectionTitle === 'physical_exam') {
                        $subsection = EncounterNoteSection::where('encounter_id', $encounter->id)
                            ->where('section_title', $sectionTitle)
                            ->first();

                        if ($subsection) {
                            $subsection->update([
                                'section_text' => json_encode($sectionData),
                            ]);
                        }
                    } else {
                        foreach ($sectionData as $subsectionTitle => $subsectionData) {
                            $subsection = EncounterNoteSection::where('encounter_id', $encounter->id)
                                ->where('section_title', $subsectionTitle)
                                ->first();

                            if ($subsection) {
                                $subsection->update([
                                    'section_text' => is_array($subsectionData) ? json_encode($subsectionData) : $subsectionData,
                                ]);
                            }
                        }
                    }
                } else {
                    return response()->json(['error' => "Unexpected data structure for section {$sectionTitle}"], 400);
                }
            }
            return response()->json(['message' => 'Data updated successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' =>  $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        PatientEncounter::destroy($id);
        $base = new BaseController();
        return $base->sendResponse(NULL, 'Patient Encounter Deleted');
    }

    public function patient_encounter_information($patient_id)
    {
        $existing_encounters = PatientEncounter::where('patient_id', $patient_id)->get();
        $providers = User::where('user_type', 'provider')->get();
        $encounter_type = ListOption::where('list_id', 'Encounter Type')->select('id', 'title')->get();
        $Specialty = ListOption::where('list_id', 'Specialty')->select('id', 'title')->get();

        // Prepare fields' names from PatientEncounter table
        $encounter_fields = Schema::getColumnListing('patient_encounters');

        // If there are no existing encounters, set $existing_encounters to an empty array
        if ($existing_encounters->isEmpty()) {
            $existing_encounters = $encounter_fields;
        }

        return response()->json([
            'existing_encounters' => $existing_encounters,

            'provider' => $providers,
            'encounter_type' => $encounter_type,
            'Specialty' => $Specialty,
        ], 200);
    }

    public function status_update(Request $request)
    {
        $request->validate([
            'encounter_id'=>'required|exists:patient_encounters,id',
            ]);
        $encounter = PatientEncounter::FindOrFail($request->encounter_id);
        if ($encounter != NULL) {
           $encounter->status = '1';
            $encounter->save();
            return response()->json([
                'code' => 'success',
                'message' => 'Status Updated'
            ], 200);
        } else {
            return response()->json(['message' => 'No Encounter Found']);
        }
    }
}
