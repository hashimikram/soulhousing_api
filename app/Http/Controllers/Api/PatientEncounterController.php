<?php

namespace App\Http\Controllers\Api;

use PDO;
use App\Models\Problem;
use App\Models\patient;
use App\Models\Vital;
use App\Models\ListOption;
use PDF;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\PhysicalExam;
use Illuminate\Http\Request;
use App\Models\ReviewOfSystem;
use App\Models\PatientEncounter;
use App\Models\PhysicalExamDetail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\EncounterNoteSection;
use App\Models\ReviewOfSystemDetail;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Schema;
use App\Http\Controllers\Api\BaseController as BaseController;

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
        $this->validateRequest($request);

        DB::beginTransaction();

        try {
            $encounter = $this->createPatientEncounter($request);
            $this->handleVitalSigns($request, $encounter);

            $sections = $this->getSections();
            $newSections = $this->createEncounterSections($request, $encounter, $sections);

            DB::commit();

            $data = $this->getEncounterData($encounter);
   
            // Get encounter note sections
            $sections = EncounterNoteSection::where('encounter_id', $encounter->id)->orderBy('id', 'ASC')->get();

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

                // Initialize dataSection
                $dataSection = [];

                if ($section->section_title == 'Review of Systems') {
                    $reviewOfSystemDetails = ReviewOfSystemDetail::where('section_id', $section->id)->get();
                    foreach ($reviewOfSystemDetails as $data) {
                        $sectionText = "General: {$data->general}\n" . "Skin: {$data->skin}\n" . "Head: {$data->head}\n" . "Eyes: {$data->eyes}\n" . "Ears: {$data->ears}\n" . "Nose: {$data->nose}\n" . "Mouth/Throat: {$data->mouth_throat}\n" . "Neck: {$data->neck}\n" . "Breasts: {$data->breasts}\n" . "Respiratory: {$data->respiratory}\n" . "cardiovascular: {$data->cardiovascular}\n" . "gastrointestinal: {$data->gastrointestinal}\n" . "Musculoskeletal: {$data->musculoskeletal}\n" . "Neurological: {$data->neurological}\n" . "Psychiatric: {$data->psychiatric}\n" . "Endocrine: {$data->endocrine}\n" . "Hematologic/Lymphatic: {$data->hematologic_lymphatic}\n" . "Allergic/Immunologic: {$data->allergic_immunologic}\n";
                    }
                } elseif ($section->section_title == 'Physical Exam') {
                    $physicalExamDetails = PhysicalExamDetail::where('section_id', $section->id)->get();
                    foreach ($physicalExamDetails as $data) {
                        $sectionText = "General Appearance: {$data->general_appearance}\n" . "Skin: {$data->skin}\n" . "Head: {$data->head}\n" . "Eyes: {$data->eyes}\n" . "Ears: {$data->ears}\n" . "Nose: {$data->nose}\n" . "Mouth/Throat: {$data->mouth_throat}\n" . "Neck: {$data->neck}\n" . "Chest/Lungs: {$data->chest_lungs}\n" . "Cardiovascular: {$data->cardiovascular}\n" . "Abdomen: {$data->abdomen}\n" . "Genitourinary: {$data->genitourinary}\n" . "Musculoskeletal: {$data->musculoskeletal}\n" . "Neurological: {$data->neurological}\n" . "Psychiatric: {$data->psychiatric}\n" . "Endocrine: {$data->endocrine}\n" . "Hematologic/Lymphatic: {$data->hematologic_lymphatic}\n" . "Allergic/Immunologic: {$data->allergic_immunologic}\n";
                    }
                } elseif ($section->section_title == 'ASSESSMENTS/CARE PLAN') {
                    $problems = Problem::where('patient_id', $section->patient_id)
                        ->where('provider_id', auth()->user()->id)
                        ->get();

                    $sectionText = ''; // Initialize an empty string to accumulate all section text

                    foreach ($problems as $data) {
                        $sectionText .= "Code: {$data->diagnosis}\n" . "Description: {$data->name}\n";
                    }
                }

                $formattedData[] = [
                    'section_id' => $section->id,
                    'section_title' => $section->section_title,
                    'section_slug' => $section->section_slug,
                    'section_text' => $sectionText,
                    'id_default' => (int) $section->id_default,
                ];
            }

            return response()->json(
                [
                    'encounter_id' => $encounter->id,
                    'encounter' => $data,
                    'new_sections' => $formattedData,
                ],
                201,
            );
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    private function validateRequest(Request $request)
    {
        $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'encounter_type' => 'required|exists:list_options,id',
            'specialty' => 'required|exists:list_options,id',
            'parent_encounter' => 'nullable|exists:patient_encounters,id',
            'reason' => 'required',
        ]);
    }

    private function createPatientEncounter(Request $request)
    {
        $encounter = new PatientEncounter();
        $encounter->patient_id = $request->patient_id;
        $encounter->provider_id = auth()->user()->id;
        $encounter->provider_id_patient = $request->provider_id_patient;
        date_default_timezone_set('Asia/Karachi');
        $encounter->encounter_date = $this->parseEncounterDate($request->signed_at);
        $encounter->signed_by = auth()->user()->id;
        $encounter->encounter_type = $request->encounter_type;
        $encounter->specialty = $request->specialty;
        $encounter->parent_encounter = $request->parent_encounter;
        $encounter->location = $request->location;
        $encounter->status = '0';
        $encounter->reason = $request->reason;

        if ($request->hasFile('attachment')) {
            $encounter->attachment = $this->handleFileUpload($request->file('attachment'));
        }

        $encounter->save();

        return $encounter;
    }

    private function parseEncounterDate($signedAt)
    {
        return date('Y-m-d h:i:s', strtotime($signedAt));
    }

    private function handleFileUpload($file)
    {
        $fileName = date('YmdHi') . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $destinationPath = public_path('uploads');
        $file->move($destinationPath, $fileName);
        return $fileName;
    }

    private function handleVitalSigns(Request $request, $encounter)
    {
        if ($request->skip != 'true') {
            $vital = new Vital();
            $vital->patient_id = $request->patient_id;
            $vital->provider_id = auth()->user()->id;
            $vital->pulse_beats_in = $request->pulse_beats_in;
            $vital->resp_rate = $request->resp_rate;
            $vital->head_in = $request->head_in;
            $vital->waist_in = $request->waist_in;
            $vital->glucose = $request->glucose;
            $vital->height_in = $request->height_in;
            $vital->weight_lbs = $request->weight_lbs;
            $vital->bmi_in = $request->bmi_in;
            $vital->systolic = $request->systolic;
            $vital->diastolic = $request->diastolic;
            $vital->body_temp_result_f = $request->body_temp_result_f;
            $vital->save();
        }
    }

    private function getSections()
    {
        return ['Chief Complaint', 'History', 'Medical History', 'Surgical History', 'Family History', 'Social History', 'Allergies', 'Medications', 'Review of Systems', 'Vital Sign', 'Physical Exam', 'ASSESSMENTS/CARE PLAN', 'Follow Up'];
    }

    private function createEncounterSections(Request $request, $encounter, $sections)
    {
        $newSections = [];

        foreach ($sections as $index => $sectionTitle) {
            $section = new EncounterNoteSection();
            $section->patient_id = $request->patient_id;
            $section->id_default = $index + 1;
            $section->provider_id = auth()->user()->id;
            $section->encounter_id = $encounter->id;
            $section->section_title = $sectionTitle;
            $section->section_text = $this->getSectionText($sectionTitle);
            $section->section_slug = Str::slug($sectionTitle);
            $section->save();

            $sectionData = $section->toArray();
            $sectionData['section_id'] = $section->id;

            // Call specific methods for Review of Systems and Physical Exam
            if ($sectionTitle == 'Review of Systems') {
                $this->createReviewOfSystemDetail($request, $section);
                $rosDetails = ReviewOfSystemDetail::where('patient_id', $request->patient_id)
                    ->where('section_id', $section->id)
                    ->where('provider_id', auth()->user()->id)
                    ->first();

                if ($rosDetails) {
                    $sectionData = $rosDetails->toArray();

                    $sectionText =
                        'Constitutional: ' .
                        $sectionData['general'] .
                        "\n" .
                        'Skin: ' .
                        $sectionData['skin'] .
                        "\n" .
                        'Head: ' .
                        $sectionData['head'] .
                        "\n" .
                        'Eyes: ' .
                        $sectionData['eyes'] .
                        "\n" .
                        'Ears: ' .
                        $sectionData['ears'] .
                        "\n" .
                        'Nose: ' .
                        $sectionData['nose'] .
                        "\n" .
                        'Mouth/Throat: ' .
                        $sectionData['mouth_throat'] .
                        "\n" .
                        'Neck: ' .
                        $sectionData['neck'] .
                        "\n" .
                        'Breasts: ' .
                        $sectionData['breasts'] .
                        "\n" .
                        'Respiratory: ' .
                        $sectionData['respiratory'] .
                        "\n" .
                        'Cardiovascular: ' .
                        $sectionData['cardiovascular'] .
                        "\n" .
                        'Gastrointestinal: ' .
                        $sectionData['gastrointestinal'] .
                        "\n" .
                        'Genitourinary: ' .
                        $sectionData['genitourinary'] .
                        "\n" .
                        'Musculoskeletal: ' .
                        $sectionData['musculoskeletal'] .
                        "\n" .
                        'Neurological: ' .
                        $sectionData['neurological'] .
                        "\n" .
                        'Psychiatric: ' .
                        $sectionData['psychiatric'] .
                        "\n" .
                        'Endocrine: ' .
                        $sectionData['endocrine'] .
                        "\n" .
                        'Hematologic/Lymphatic: ' .
                        $sectionData['hematologic_lymphatic'] .
                        "\n" .
                        'Allergic/Immunologic: ' .
                        $sectionData['allergic_immunologic'] .
                        "\n";

                    $sectionData['section_text'] = $sectionText;
                }
            } elseif ($sectionTitle == 'Physical Exam') {
                $this->createPhysicalExamDetail($request, $section);
                $rosDetails = PhysicalExamDetail::where('patient_id', $request->patient_id)
                    ->where('section_id', $section->id)
                    ->where('provider_id', auth()->user()->id)
                    ->first();

                if ($rosDetails) {
                    $sectionData = $rosDetails->toArray();

                    $sectionText =
                        'General Appearance: ' . $sectionData['general_appearance'] . "\n" . 'Skin: ' . $sectionData['skin'] . "\n" . 'Head: ' . $sectionData['head'] . "\n" . 'Eyes: ' . $sectionData['eyes'] . "\n" . 'Ears: ' . $sectionData['ears'] . "\n" . 'Nose: ' . $sectionData['nose'] . "\n" . 'Mouth/Throat: ' . $sectionData['mouth_throat'] . "\n" . 'Neck: ' . $sectionData['neck'] . "\n" . 'Chest/Lungs: ' . $sectionData['chest_lungs'] . "\n" . 'Cardiovascular: ' . $sectionData['cardiovascular'] . "\n" . 'Abdomen: ' . $sectionData['abdomen'] . "\n" . 'Genitourinary: ' . $sectionData['genitourinary'] . "\n" . 'Musculoskeletal: ' . $sectionData['musculoskeletal'] . "\n" . 'Neurological: ' . $sectionData['neurological'] . "\n" . 'Psychiatric: ' . $sectionData['psychiatric'] . "\n" . 'Endocrine: ' . $sectionData['endocrine'] . "\n" . 'Hematologic/Lymphatic: ' . $sectionData['hematologic_lymphatic'] . "\n" . 'Allergic/Immunologic: ' . $sectionData['allergic_immunologic'] . "\n";

                    $sectionData['section_text'] = $sectionText;
                }
            }

            $newSections[] = $sectionData;
        }

        return $newSections;
    }

    private function getSectionText($sectionTitle)
    {
        $templates = [
            'Review of Systems' => "Constitutional:  \n HEENT: \n CV: \n GI: \n GU: \n Musculoskeletal: \n Skin: \n Psychiatric: \n Endocrine: \n Physical exam: \n",
            'Physical Exam' => "General Appearance: \n Head and Neck: \n Eyes: \n Ears: \n Nose: \n Mouth & Throat: \n Cardiovascular: \n Respiratory System: \n Abdomen: \n Musculoskeletal System: \n Neurological System: \n Genitourinary System: \n Psychosocial Assessment:",
        ];

        return $templates[$sectionTitle] ?? '';
    }

    private function createReviewOfSystemDetail(Request $request, $section)
    {
        $existingRecord = ReviewOfSystemDetail::where('patient_id', $request->patient_id)
            ->where('section_id', $section->id)
            ->where('provider_id', auth()->user()->id)
            ->first();

        if (!$existingRecord) {
            $reviewOfSystemDetail = new ReviewOfSystemDetail();
            $reviewOfSystemDetail->provider_id = auth()->user()->id;
            $reviewOfSystemDetail->patient_id = $request->patient_id;
            $reviewOfSystemDetail->section_id = $section->id;
            $reviewOfSystemDetail->general = 'No fever, chills, or weight changes. No fatigue, malaise, or weakness.';
            $reviewOfSystemDetail->skin = 'No rashes, lumps, itching, dryness, color changes, or lesions.';
            $reviewOfSystemDetail->head = 'No headaches, dizziness, or head injury.';
            $reviewOfSystemDetail->eyes = 'Vision is normal without blurring or double vision. No pain, redness, discharge, or recent changes in vision.';
            $reviewOfSystemDetail->ears = 'No hearing loss, ringing, or pain. No discharge.';
            $reviewOfSystemDetail->nose = 'No nasal congestion, discharge, nosebleeds, or sinus pain.';
            $reviewOfSystemDetail->mouth_throat = 'No sore throat, bleeding gums, or hoarseness. No dental issues.';
            $reviewOfSystemDetail->neck = 'No lumps, pain, or stiffness.';
            $reviewOfSystemDetail->breasts = 'No lumps, pain, or nipple discharge.';
            $reviewOfSystemDetail->respiratory = 'No cough, shortness of breath, wheezing, or chest pain.';
            $reviewOfSystemDetail->cardiovascular = 'No chest pain, palpitations, or irregular heartbeat. No swelling in extremities.';
            $reviewOfSystemDetail->gastrointestinal = 'No nausea, vomiting, diarrhea, or constipation. No abdominal pain, heartburn, or blood in stool.';
            $reviewOfSystemDetail->genitourinary = 'No difficulty urinating, frequency, urgency, or incontinence. No blood in urine or pain during urination.';
            $reviewOfSystemDetail->musculoskeletal = 'No muscle or joint pain, stiffness, swelling, or weakness.';
            $reviewOfSystemDetail->neurological = 'No seizures, fainting, or dizziness. No weakness, numbness, or tingling.';
            $reviewOfSystemDetail->psychiatric = 'No anxiety, depression, mood changes, or sleep disturbances.';
            $reviewOfSystemDetail->endocrine = 'No excessive thirst or urination. No heat or cold intolerance.';
            $reviewOfSystemDetail->hematologic_lymphatic = 'No easy bruising or bleeding. No enlarged lymph nodes.';
            $reviewOfSystemDetail->allergic_immunologic = 'No known allergies. No recurrent infections.';
            $reviewOfSystemDetail->save();
        }
    }

    private function createPhysicalExamDetail(Request $request, $section)
    {
        $existingRecord = PhysicalExamDetail::where('patient_id', $request->patient_id)
            ->where('section_id', $section->id)
            ->where('provider_id', auth()->user()->id)
            ->first();

        if (!$existingRecord) {
            $physicalExamDetail = new PhysicalExamDetail();
            $physicalExamDetail->provider_id = auth()->user()->id;
            $physicalExamDetail->patient_id = $request->patient_id;
            $physicalExamDetail->section_id = $section->id;
            $physicalExamDetail->general_appearance = 'Patient is alert, oriented, and appears well-nourished and well-developed. No apparent distress.';
            $physicalExamDetail->skin = 'Skin is warm, dry, and intact with normal color and turgor. No rashes, lesions, or abnormalities noted.';
            $physicalExamDetail->head = 'Normocephalic and atraumatic. No tenderness or deformities.';
            $physicalExamDetail->eyes = 'Pupils equal, round, and reactive to light and accommodation (PERRLA). Extraocular movements intact. Sclerae are white, conjunctivae are pink, and no discharge or abnormalities noted. Visual acuity normal.';
            $physicalExamDetail->ears = 'Ears are symmetrical with no discharge or lesions. Tympanic membranes are intact and pearly gray with good light reflex. Hearing is normal.';
            $physicalExamDetail->nose = 'Nasal mucosa is pink and moist. No septal deviation or polyps. No sinus tenderness.';
            $physicalExamDetail->mouth_throat = 'Oral mucosa is pink and moist. Teeth are in good repair. Pharynx is non-erythematous and tonsils are not enlarged. No lesions or abnormalities noted.';
            $physicalExamDetail->neck = 'Neck is supple with full range of motion. No lymphadenopathy or masses. Thyroid is non-palpable and without enlargement.';
            $physicalExamDetail->chest_lungs = 'Chest is symmetrical with normal respiratory effort. Breath sounds are clear to auscultation bilaterally. No wheezes, rales, or rhonchi.';
            $physicalExamDetail->cardiovascular = 'Heart sounds are normal with regular rate and rhythm. No murmurs, rubs, or gallops. Peripheral pulses are 2+ and equal bilaterally. No edema noted.';
            $physicalExamDetail->abdomen = 'Abdomen is flat and non-tender with active bowel sounds in all quadrants. No masses or organomegaly. No signs of hepatosplenomegaly.';
            $physicalExamDetail->genitourinary = 'External genitalia are normal in appearance. No hernias or masses. No tenderness on palpation.';
            $physicalExamDetail->musculoskeletal = 'Full range of motion in all joints. No deformities, swelling, or tenderness. Muscle strength is 5/5 bilaterally in all extremities.';
            $physicalExamDetail->neurological = 'Alert and oriented to person, place, and time. Cranial nerves II-XII intact. Motor and sensory functions are normal. Reflexes are 2+ and symmetric. Gait is steady.';
            $physicalExamDetail->psychiatric = 'Patient has normal mood and affect. Appropriate behavior. Speech is clear and coherent. No signs of anxiety or depression.';
            $physicalExamDetail->endocrine = 'No thyroid enlargement or tenderness. No signs of hormonal imbalance.';
            $physicalExamDetail->hematologic_lymphatic = 'No palpable lymphadenopathy. No signs of bruising or bleeding.';
            $physicalExamDetail->allergic_immunologic = 'No signs of allergic reactions. Skin tests, if performed, are negative.';
            $physicalExamDetail->save();
        }
    }

    private function getEncounterData($encounter)
    {
        return PatientEncounter::where('patient_encounters.id', $encounter->id)
            ->leftJoin('list_options as encounter_type', 'encounter_type.id', '=', 'patient_encounters.encounter_type')
            ->leftJoin('list_options as specialty', 'specialty.id', '=', 'patient_encounters.specialty')
            ->leftJoin('users as provider', 'provider.id', '=', 'patient_encounters.provider_id_patient')
            ->leftJoin('patients', 'patients.id', '=', 'patient_encounters.patient_id')
            ->select('patient_encounters.id', 'patient_encounters.encounter_date', 'patient_encounters.patient_id', 'encounter_type.title as encounter_type_title', 'specialty.title as specialty_title', 'provider.name as provider_name', 'patients.mrn_no', DB::raw("CONCAT(patients.first_name, ' ', patients.last_name) AS patient_full_name"), 'patients.date_of_birth', 'patients.gender')
            ->first();
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
            Log::info($sectionSlug);
           $existingSection = EncounterNoteSection::where('encounter_id', $encounter_id)->where('section_slug',$sectionSlug)
             ->first();
             Log::info($existingSection->id);
        if ($existingSection) {
            $existingSection->section_text = $sectionData['section_text'];
            $existingSection->save();
            Log::info('Section Text Updated');
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

        return response()->json(['message' => 'Notes Updated Successfully'], 200);
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
        $sections = EncounterNoteSection::where('encounter_id', $encounter_id)->orderBy('id', 'ASC')->get();

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

            // Initialize dataSection
            $dataSection = [];

            if ($section->section_title == 'Review of Systems') {
                $reviewOfSystemDetails = ReviewOfSystemDetail::where('section_id', $section->id)->get();
                foreach ($reviewOfSystemDetails as $data) {
                    $sectionText = "General: {$data->general}\n" . "Skin: {$data->skin}\n" . "Head: {$data->head}\n" . "Eyes: {$data->eyes}\n" . "Ears: {$data->ears}\n" . "Nose: {$data->nose}\n" . "Mouth/Throat: {$data->mouth_throat}\n" . "Neck: {$data->neck}\n" . "Breasts: {$data->breasts}\n" . "Respiratory: {$data->respiratory}\n" . "cardiovascular: {$data->cardiovascular}\n" . "gastrointestinal: {$data->gastrointestinal}\n" . "Musculoskeletal: {$data->musculoskeletal}\n" . "Neurological: {$data->neurological}\n" . "Psychiatric: {$data->psychiatric}\n" . "Endocrine: {$data->endocrine}\n" . "Hematologic/Lymphatic: {$data->hematologic_lymphatic}\n" . "Allergic/Immunologic: {$data->allergic_immunologic}\n";
                }
            } elseif ($section->section_title == 'Physical Exam') {
                $physicalExamDetails = PhysicalExamDetail::where('section_id', $section->id)->get();
                foreach ($physicalExamDetails as $data) {
                    $sectionText = "General Appearance: {$data->general_appearance}\n" . "Skin: {$data->skin}\n" . "Head: {$data->head}\n" . "Eyes: {$data->eyes}\n" . "Ears: {$data->ears}\n" . "Nose: {$data->nose}\n" . "Mouth/Throat: {$data->mouth_throat}\n" . "Neck: {$data->neck}\n" . "Chest/Lungs: {$data->chest_lungs}\n" . "Cardiovascular: {$data->cardiovascular}\n" . "Abdomen: {$data->abdomen}\n" . "Genitourinary: {$data->genitourinary}\n" . "Musculoskeletal: {$data->musculoskeletal}\n" . "Neurological: {$data->neurological}\n" . "Psychiatric: {$data->psychiatric}\n" . "Endocrine: {$data->endocrine}\n" . "Hematologic/Lymphatic: {$data->hematologic_lymphatic}\n" . "Allergic/Immunologic: {$data->allergic_immunologic}\n";
                }
            } elseif ($section->section_title == 'ASSESSMENTS/CARE PLAN') {
                $problems = Problem::where('patient_id', $section->patient_id)
                    ->where('provider_id', auth()->user()->id)
                    ->get();

                $sectionText = ''; // Initialize an empty string to accumulate all section text

                foreach ($problems as $data) {
                    $sectionText .= "Code: {$data->diagnosis}\n" . "Description: {$data->name}\n";
                }
            }

            $formattedData[] = [
                'section_id' => $section->id,
                'section_title' => $section->section_title,
                'section_slug' => $section->section_slug,
                'section_text' => $sectionText,
                'id_default' => (int) $section->id_default,
            ];
        }

        $response = [
            'success' => true,
            'data' => $formattedData,
            'message' => 'Encounter note sections fetched successfully',
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
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        PatientEncounter::destroy($id);
        $base = new BaseController();
        return $base->sendResponse(null, 'Patient Encounter Deleted');
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

        return response()->json(
            [
                'existing_encounters' => $existing_encounters,

                'provider' => $providers,
                'encounter_type' => $encounter_type,
                'Specialty' => $Specialty,
            ],
            200,
        );
    }

    public function status_update(Request $request)
    {
        $request->validate([
            'encounter_id' => 'required|exists:patient_encounters,id',
        ]);
        $encounter = PatientEncounter::FindOrFail($request->encounter_id);
        if ($encounter != null) {
            $encounter->status = '1';
          
            $patient=patient::where('id',$encounter->patient_id)->first();
            if($patient){
                $data = [
                'name' => $patient->first_name .' '. $patient->last_name,
                'encounter_id' => $encounter->id,
                'data'=>$encounter->encounter_date,
            ];

            // Generate PDF
            $pdf = PDF::loadView('PDF.status_change', $data);
            $encounterDate = \Carbon\Carbon::parse($encounter->encounter_date)->format('Y-m-d_H-i-s');
            $today_date=Carbon::now()->format('d-M-Y');
            $patientId = $encounter->patient_id;
            $fileName = "encounter_{$encounterDate}_patient_{$patientId}_{$today_date}_.pdf";
            // Ensure the directory exists
            $directoryPath = public_path('uploads');
            if (!file_exists($directoryPath)) {
                mkdir($directoryPath, 0777, true);
            }
            $filePath = $directoryPath . '/' . $fileName;
            $pdf->save($filePath);
            }
            $encounter->pdf_make=$fileName;
              $encounter->save();
           
            return response()->json([
                'code' => 'success',
                'message' => 'Status Updated',
            ], 200);
        } else {
            return response()->json(['message' => 'No Encounter Found']);
        }
    }
}
