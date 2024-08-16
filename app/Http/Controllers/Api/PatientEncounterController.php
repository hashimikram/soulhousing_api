<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController as BaseController;
use App\Models\EncounterNoteSection;
use App\Models\EncounterTemplate;
use App\Models\ListOption;
use App\Models\patient;
use App\Models\PatientEncounter;
use App\Models\PhysicalExamDetail;
use App\Models\Problem;
use App\Models\ReviewOfSystemDetail;
use App\Models\Vital;
use App\Models\Wound;
use App\Models\WoundDetails;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use PDF;

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
            $check_speciality = ListOption::where('id', $encounter->specialty)->first();
            $formattedData = [];
            $encounter_details = null;


            if (isset($check_speciality)) {
                if ($check_speciality->option_id == 'psychiatrist') {
                    $this->encounter_note_template_psychiatrist($request, $encounter);
                    $psychiatrist_template = EncounterTemplate::where('patient_id',
                        $encounter->patient_id)->where('encounter_id', $encounter->id)->where('template_name',
                        'psychatric_template')->first();
                    $encounterTemplateData = $psychiatrist_template->encounter_template;

                    if (!is_array($encounterTemplateData)) {
                        $decodedText = json_decode($encounterTemplateData, true);
                    } else {
                        $decodedText = $encounterTemplateData;
                    }

// Define the section structure
                    $sections = [
                        [
                            'section_title' => 'Chief Complaint', 'section_slug' => 'chief_complaint',
                            'sorting_order' => '1'
                        ],
                        [
                            'section_title' => 'History Of Present Illness',
                            'section_slug' => 'history_of_present_illness', 'sorting_order' => '2'
                        ],
                        ['section_title' => 'Allergies', 'section_slug' => 'allergies', 'sorting_order' => '3'],
                        ['section_title' => 'Diagnosis', 'section_slug' => 'diagnosis', 'sorting_order' => '4'],
                        [
                            'section_title' => 'Assessments', 'section_slug' => 'assessments', 'sorting_order' => '5'
                        ],
                        ['section_title' => 'Procedures', 'section_slug' => 'procedures', 'sorting_order' => '6'],
                        ['section_title' => 'Medications', 'section_slug' => 'medications', 'sorting_order' => '7'],
                        ['section_title' => 'Care Plan', 'section_slug' => 'care_plan', 'sorting_order' => '8']
                    ];

                    return $sections;

// Format the response
                    $formattedData = [];

                    foreach ($sections as $key => $section) {
                        if ($section == 'Assessments') {
                            $data = $this->create_psychatric_section($encounter);
                        } else {
                            $data = $decodedText['section_text'];
                        }
                        $formattedSection = [
                            'section_id' => $psychiatrist_template->id + $key,  // Unique ID for each section
                            'section_title' => $section['section_title'],
                            'section_slug' => $section['section_slug'],
                            'section_text' => $data ?? '',
                            'section_type_2' => 'psychiatrist',
                            // Default to empty if not set
                            'id_default' => $key + 1
                        ];

                        $formattedData[] = $formattedSection;
                    }
                } elseif ($check_speciality->option_id == 'wound') {
                    $this->encounter_note_template_wound($request, $encounter);
                    // Fetch the wound template data
                    $wound_template = EncounterTemplate::where('patient_id', $encounter->patient_id)
                        ->where('encounter_id', $encounter->id)
                        ->where('template_name', 'wound')
                        ->first();

                    $encounterTemplateData = $wound_template->encounter_template;

                    if (!is_array($encounterTemplateData)) {
                        $decodedText = json_decode($encounterTemplateData, true);
                    } else {
                        $decodedText = $encounterTemplateData;
                    }

// Define the section structure
                    $sections = [
                        [
                            'section_title' => 'Progress Note', 'section_slug' => 'progress_note',
                            'sorting_order' => '1'
                        ],
                        [
                            'section_title' => 'Wound Evaluation',
                            'section_slug' => 'wound_evaluation', 'sorting_order' => '2'
                        ],
                        ['section_title' => 'Procedure', 'section_slug' => 'procedure', 'sorting_order' => '3'],
                        ['section_title' => 'Diagnosis', 'section_slug' => 'diagnosis', 'sorting_order' => '4'],
                        [
                            'section_title' => 'Treatment Order', 'section_slug' => 'treatment_order',
                            'sorting_order' => '5'
                        ],
                        [
                            'section_title' => 'Care Plan/patients Instructions',
                            'section_slug' => 'care_plan_patient_instructions',
                            'sorting_order' => '6'
                        ],

                    ];

// Format the response
                    $formattedData = [];

                    foreach ($sections as $key => $section) {
                        $formattedSection = [
                            'section_id' => $wound_template->id + $key,  // Unique ID for each section
                            'section_title' => $section['section_title'],
                            'section_slug' => $section['section_slug'],
                            'section_text' => $decodedText['section_text'] ?? '',
                            'section_type_2' => 'wound',
                            // Default to empty if not set
                            'id_default' => $key + 1
                        ];

                        // Add the 'wounded_type' key if the section_slug is 'wound_evaluation'
                        if ($section['section_slug'] == 'wound_evaluation') {
                            $formattedSection['section_type'] = true;
                        }

                        $formattedData[] = $formattedSection;
                    }


                } else {
                    // Get encounter note sections
                    $sections = EncounterNoteSection::where('encounter_id', $encounter->id)->orderBy('id',
                        'ASC')->get();

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
                                $sectionText = "Constitutional: {$data->constitutional}\n".
                                    "Heent: {$data->heent}\n".
                                    "General: {$data->general}\n".
                                    "Skin: {$data->skin}\n".
                                    "Head: {$data->head}\n".
                                    "Eyes: {$data->eyes}\n".
                                    "Ears: {$data->ears}\n".
                                    "Nose: {$data->nose}\n".
                                    "Mouth/Throat: {$data->mouth_throat}\n".
                                    "Neck: {$data->neck}\n".
                                    "Respiratory: {$data->respiratory}\n".
                                    "Cardiovascular: {$data->cardiovascular}\n".
                                    "Gastrointestinal: {$data->gastrointestinal}\n".
                                    "Genitourinary: {$data->genitourinary}\n".
                                    "Musculoskeletal: {$data->musculoskeletal}\n".
                                    "Neurological: {$data->neurological}\n".
                                    "Psychiatric: {$data->psychiatric}\n".
                                    "Endocrine: {$data->endocrine}\n".
                                    "Hematologic/Lymphatic: {$data->hematologic_lymphatic}\n".
                                    "Allergic/Immunologic: {$data->allergic_immunologic}\n".
                                    "Integumentry: {$data->integumentry}\n";
                            }
                        } elseif ($section->section_title == 'Physical Exam') {
                            $physicalExamDetails = PhysicalExamDetail::where('section_id', $section->id)->get();
                            foreach ($physicalExamDetails as $data) {
                                $sectionText = "General Appearance: {$data->general_appearance}\n"."Skin: {$data->skin}\n"."Head: {$data->head}\n"."Eyes: {$data->eyes}\n"."Ears: {$data->ears}\n"."Nose: {$data->nose}\n"."Mouth/Throat: {$data->mouth_throat}\n"."Neck: {$data->neck}\n"."Chest/Lungs: {$data->chest_lungs}\n"."Cardiovascular: {$data->cardiovascular}\n"."Abdomen: {$data->abdomen}\n"."Genitourinary: {$data->genitourinary}\n"."Musculoskeletal: {$data->musculoskeletal}\n"."Neurological: {$data->neurological}\n"."Psychiatric: {$data->psychiatric}\n"."Endocrine: {$data->endocrine}\n"."Hematologic/Lymphatic: {$data->hematologic_lymphatic}\n"."Allergic/Immunologic: {$data->allergic_immunologic}\n";
                            }
                        } elseif ($section->section_title == 'ASSESSMENTS/CARE PLAN') {
                            $problems = Problem::where('patient_id', $section->patient_id)
                                ->where('provider_id', auth()->user()->id)
                                ->get();

                            $sectionText = ''; // Initialize an empty string to accumulate all section text

                            foreach ($problems as $data) {
                                $sectionText .= "Code: {$data->diagnosis}\n"."Description: {$data->name}\n";
                            }
                        }

                        $formattedData[] = [
                            'section_id' => $section->id,
                            'section_title' => $section->section_title,
                            'section_slug' => $section->section_slug,
                            'section_text' => $sectionText,
                            'section_type_2' => 'general',
                            'id_default' => (int) $section->id_default,
                        ];
                    }
                }

                // Fetch encounter details
                $encounter_details = PatientEncounter::join('list_options as encounter_type', 'encounter_type.id', '=',
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
                        'patients.first_name', 'patients.middle_name', 'patients.last_name',
                        'patients.date_of_birth', 'patients.gender')
                    ->where('patient_encounters.id', $encounter->id)
                    ->first();
            }

            if (!empty($encounter_details->last_name)) {
                $parts[] = $encounter_details->last_name;
            }

            if (!empty($encounter_details->first_name)) {
                $parts[] = $encounter_details->first_name;
            }

            if (!empty($encounter_details->middle_name)) {
                $parts[] = ucfirst(substr($encounter_details->middle_name, 0, 1));
            }

            $encounter_details->patient_full_name = implode(', ', $parts);

            return response()->json([
                'encounter_id' => $encounter->id,
                'encounter_details' => $encounter_details,
                'new_sections' => $formattedData,
            ], 201);

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
            'blood_pressure' => 'nullable',
            'pulse_beats_in' => 'nullable',
            'resp_rate' => 'nullable',
        ]);
    }

    private function createPatientEncounter(Request $request)
    {
        $encounter = new PatientEncounter();
        $encounter->patient_id = $request->patient_id;
        $encounter->provider_id = auth()->user()->id;
        $encounter->provider_id_patient = auth()->user()->id;
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
        $fileName = date('YmdHi').'_'.uniqid().'.'.$file->getClientOriginalExtension();
        $destinationPath = public_path('uploads');
        $file->move($destinationPath, $fileName);
        return $fileName;
    }

    private function handleVitalSigns(Request $request, $encounter)
    {
        ;
        if ($request->skip != 'true') {
            $vital = new Vital();
            $vital->date = $request->signed_at;
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
            $vital->blood_pressure = $request->blood_pressure;
            $vital->save();
        }
    }

    private function getSections()
    {
        return [
            'Chief Complaint', 'History', 'Medical History', 'Surgical History', 'Family History', 'Social History',
            'Allergies', 'Medications', 'Review of Systems', 'Vital Sign', 'Physical Exam', 'ASSESSMENTS/CARE PLAN',
            'Follow Up'
        ];
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
            $check_speciality = ListOption::where('id', $encounter->specialty)->first();
            // Call specific methods for Review of Systems and Physical Exam
            if ($sectionTitle == 'Review of Systems') {
                $this->createReviewOfSystemDetail($request, $section);
            } elseif ($sectionTitle == 'Physical Exam') {
                $this->createPhysicalExamDetail($request, $section);
                $rosDetails = PhysicalExamDetail::where('patient_id', $request->patient_id)
                    ->where('section_id', $section->id)
                    ->where('provider_id', auth()->user()->id)
                    ->first();

                if ($rosDetails) {
                    $sectionData = $rosDetails->toArray();

                    $sectionText =
                        'General Appearance: '.$sectionData['general_appearance']."\n".'Skin: '.$sectionData['skin']."\n".'Head: '.$sectionData['head']."\n".'Eyes: '.$sectionData['eyes']."\n".'Ears: '.$sectionData['ears']."\n".'Nose: '.$sectionData['nose']."\n".'Mouth/Throat: '.$sectionData['mouth_throat']."\n".'Neck: '.$sectionData['neck']."\n".'Chest/Lungs: '.$sectionData['chest_lungs']."\n".'Cardiovascular: '.$sectionData['cardiovascular']."\n".'Abdomen: '.$sectionData['abdomen']."\n".'Genitourinary: '.$sectionData['genitourinary']."\n".'Musculoskeletal: '.$sectionData['musculoskeletal']."\n".'Neurological: '.$sectionData['neurological']."\n".'Psychiatric: '.$sectionData['psychiatric']."\n".'Endocrine: '.$sectionData['endocrine']."\n".'Hematologic/Lymphatic: '.$sectionData['hematologic_lymphatic']."\n".'Allergic/Immunologic: '.$sectionData['allergic_immunologic']."\n";

                    $sectionData['section_text'] = $sectionText;
                }
            } elseif ($sectionTitle == 'ASSESSMENTS/CARE PLAN') {
                $this->create_psychatric_section($encounter);
            }

            $newSections[] = $sectionData;
        }

        return $newSections;
    }

    private function getSectionText($sectionTitle)
    {
        $templates = [
            'Review of Systems' => "Constitutional:Denies weight loss, weight gain, or fatigue. Denies fever, chills, or night sweats. \n
                            Heent: Denies headaches, vision changes, hearing loss, nasal congestion, and sore throat. Normal examination findings as described above for head, eyes, ears, nose, and throat. \n
                            General: Weight loss, weight gain, or fatigue. Denies fever, chills, or night sweats. \n
                            Skin: Denies rashes, itching, or bruising. Skin is warm and dry with normal turgor. \n
                            Head: Denies headaches, trauma, or dizziness. Scalp and skull are normal upon. \n
                            Eyes: Denies vision changes, redness, or discharge. Pupils are equal, round, and reactive to light and accommodation. Extraocular movements are intact. \n
                            Ears: Denies hearing loss, tinnitus, or ear pain. Tympanic membranes are clear with normal landmarks. \n
                            Nose: Denies nasal congestion, discharge, or nosebleeds. Nasal passages are clear. \n
                            Mouth & Throat: Denies sore throat, difficulty swallowing, or mouth sores. Oral mucosa is moist, and oropharynx is clear without erythema or exudates. \n
                            Neck: Denies lumps, swelling, or stiffness. Neck is supple with full range of motion. No lymphadenopathy. \n
                            Respiratory: Denies cough, shortness of breath, or wheezing. Breath sounds are clear to auscultation bilaterally. No rales, rhonchi, or wheezes. \n
                            Cardiovascular: Denies chest pain, palpitations, or edema. Heart rate and rhythm are regular. No murmurs, rubs, or gallops. Peripheral pulses are intact. \n
                            Gastrointestinal: Denies abdominal pain, nausea, vomiting, diarrhea, or constipation. Abdomen is soft, non-tender, and non-distended. Bowel sounds are normal. \n
                            Genitourinary: Denies dysuria, hematuria, or urinary frequency. Denies genital lesions or discharge. Normal urination. \n
                            Musculoskeletal: Denies joint pain, swelling, or stiffness. Full range of motion in all extremities. No deformities or tenderness. \n
                            Neurological: Denies weakness, numbness, or seizures. Cranial nerves II-XII are intact. Strength and sensation are normal. Reflexes are 2+ and symmetrical. \n
                            Psychiatric: Denies anxiety, depression, or mood changes. Normal affect and behavior. Oriented to person, place, and time. \n
                            Endocrine: Denies polyuria, polydipsia, or heat/cold intolerance. Thyroid is not enlarged. \n
                            Hematologic/Lymphatic: Denies easy bruising, bleeding, or lymph node enlargement. No pallor or cyanosis. \n
                            Allergic/Immunologic: Denies known allergies. Denies history of frequent infections. \n
                            Integumentry: Denies rashes, itching, or bruising. Skin is warm and dry with normal turgor.",
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
            $reviewOfSystemDetail->general = 'Weight loss, weight gain, or fatigue. Denies fever, chills, or night sweats.';
            $reviewOfSystemDetail->skin = 'Denies rashes, itching, or bruising. Skin is warm and dry with normal turgor.';
            $reviewOfSystemDetail->head = 'Denies headaches, trauma, or dizziness. Scalp and skull are normal upon';
            $reviewOfSystemDetail->eyes = 'Denies vision changes, redness, or discharge. Pupils are equal, round, and reactive to light and accommodation. Extraocular movements are intact.';
            $reviewOfSystemDetail->ears = 'Denies hearing loss, tinnitus, or ear pain. Tympanic membranes are clear with normal landmarks.';
            $reviewOfSystemDetail->ears = 'Denies nasal congestion, discharge, or nosebleeds. Nasal passages are clear.';
            $reviewOfSystemDetail->mouth_throat = 'Denies sore throat, difficulty swallowing, or mouth sores. Oral mucosa is moist, and oropharynx is clear without erythema or exudates.';
            $reviewOfSystemDetail->neck = 'Denies lumps, swelling, or stiffness. Neck is supple with full range of motion. No lymphadenopathy.';
            $reviewOfSystemDetail->respiratory = 'Denies cough, shortness of breath, or wheezing. Breath sounds are clear to auscultation bilaterally. No rales, rhonchi, or wheezes.';
            $reviewOfSystemDetail->cardiovascular = 'Denies chest pain, palpitations, or edema. Heart rate and rhythm are regular. No murmurs, rubs, or gallops. Peripheral pulses are intact.';
            $reviewOfSystemDetail->gastrointestinal = 'Denies abdominal pain, nausea, vomiting, diarrhea, or constipation. Abdomen is soft, non-tender, and non-distended. Bowel sounds are normal.';
            $reviewOfSystemDetail->genitourinary = 'Denies dysuria, hematuria, or urinary frequency. Denies genital lesions or discharge. Normal urination.';
            $reviewOfSystemDetail->musculoskeletal = 'Denies joint pain, swelling, or stiffness. Full range of motion in all extremities. No deformities or tenderness.';
            $reviewOfSystemDetail->neurological = 'Denies weakness, numbness, or seizures. Cranial nerves II-XII are intact. Strength and sensation are normal. Reflexes are 2+ and symmetrical.';
            $reviewOfSystemDetail->psychiatric = 'Denies anxiety, depression, or mood changes. Normal affect and behavior. Oriented to person, place, and time.';
            $reviewOfSystemDetail->endocrine = 'Denies polyuria, polydipsia, or heat/cold intolerance. Thyroid is not enlarged.';
            $reviewOfSystemDetail->hematologic_lymphatic = 'Denies easy bruising, bleeding, or lymph node enlargement. No pallor or cyanosis.';
            $reviewOfSystemDetail->allergic_immunologic = 'Denies known allergies. Denies history of frequent infections or autoimmune diseases.';
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
            $physicalExamDetail->general_appearance = 'patients is alert, oriented, and appears well-nourished and well-developed. No apparent distress.';
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
            $physicalExamDetail->psychiatric = 'patients has normal mood and affect. Appropriate behavior. Speech is clear and coherent. No signs of anxiety or depression.';
            $physicalExamDetail->endocrine = 'No thyroid enlargement or tenderness. No signs of hormonal imbalance.';
            $physicalExamDetail->hematologic_lymphatic = 'No palpable lymphadenopathy. No signs of bruising or bleeding.';
            $physicalExamDetail->allergic_immunologic = 'No signs of allergic reactions. Skin tests, if performed, are negative.';
            $physicalExamDetail->save();
        }
    }

    public function create_psychatric_section($encounter)
    {
        $template = "APPERANCE: Well-groomed MOTOR. \n
    BEHAVIOR: Calm. \n
    ATTITUDE: Cooperative MOOD good. \n
    AFFECT: Appropriate. \n
    SPEECH: Normal. \n
    ORIENTATION: A&Ox3. \n
    PERCEPTION: normal. \n
    THOUGHT PROCESS: Spontaneous. \n
    THOUGHT CONTENT: Appropriate. \n
    CONCENTRATION: Good. \n
    MEMORY: no deficit. \n
    INTELLIGENCE: Good. \n
    IMPULSE CONTROL: fair. \n
    INSITE: good. \n
    JUDGEMENT: good. \n
    RISK ASSESSMENT: Suicidal Ideation/Homicidal Ideation denied. Access to Firearms denied.";

        return $template;
    }

    private function getEncounterData($encounter)
    {
        return PatientEncounter::where('patient_encounters.id', $encounter->id)
            ->leftJoin('list_options as encounter_type', 'encounter_type.id', '=', 'patient_encounters.encounter_type')
            ->leftJoin('list_options as specialty', 'specialty.id', '=', 'patient_encounters.specialty')
            ->leftJoin('users as provider', 'provider.id', '=', 'patient_encounters.provider_id_patient')
            ->leftJoin('patients', 'patients.id', '=', 'patient_encounters.patient_id')
            ->select('patient_encounters.id', 'patient_encounters.encounter_date', 'patient_encounters.patient_id',
                'encounter_type.title as encounter_type_title', 'specialty.title as specialty_title',
                'provider.name as provider_name', 'patients.mrn_no',
                DB::raw("CONCAT(patients.first_name, ' ', patients.last_name) AS patient_full_name"),
                'patients.date_of_birth', 'patients.gender')
            ->first();
    }

    public function encounter_note_template_psychiatrist(Request $request, $encounter)
    {
        $data = [
            [
                "section_title" => "Chief Complaint",
                "section_text" => null,
                "sorting_order" => "1",
                "section_slug" => "chief_complaint"
            ],
            [
                "section_title" => "History Of Present Illness",
                "section_text" => null,
                "sorting_order" => "2",
                "section_slug" => "history_of_present_illness"
            ],
            [
                "section_title" => "Allergies",
                "section_text" => null,
                "sorting_order" => "3",
                "section_slug" => "allergies"
            ],
            [
                "section_title" => "Diagnosis",
                "section_text" => null,
                "sorting_order" => "4",
                "section_slug" => "diagnosis"
            ],
            [
                "section_title" => "Assessments",
                "section_text" => null,
                "sorting_order" => "5",
                "section_slug" => "assessments"
            ],
            [
                "section_title" => "Procedures",
                "section_text" => null,
                "sorting_order" => "6",
                "section_slug" => "procedures"
            ],
            [
                "section_title" => "Medications",
                "section_text" => null,
                "sorting_order" => "7",
                "section_slug" => "medications"
            ],
            [
                "section_title" => "Care Plan",
                "section_text" => null,
                "sorting_order" => "8",
                "section_slug" => "care_plan"
            ]
        ];

        $template = new EncounterTemplate();
        $template->provider_id = auth()->user()->id;
        $template->patient_id = $encounter->patient_id;
        $template->encounter_id = $encounter->id;
        $template->template_name = 'psychatric_template';
        $template->encounter_template = json_encode($data);
        $template->save();
    }

    public function encounter_note_template_wound(Request $request, $encounter)
    {
        $data = [
            [
                "section_title" => "Progress Note",
                "section_text" => "patients is a 54 year old male seen at Soul Housing Recuperative Home for for follow up on right leg wounds. ",
                "sorting_order" => "1",
                "section_slug" => "progress_note"
            ],
            [
                "section_title" => "Wound Evaluation",
                "section_text" => "wound",
                "sorting_order" => "2",
                "section_slug" => "wound_evaluation"
            ],
            [
                "section_title" => "Procedure",
                "section_text" => "RIGHT KNEE:The pre-procedure area was prepped in the usual aseptic manner. Local anesthesia was achieved with lidocaine spray. The chronic non-healing ulceration was debrided by mechanical methods. Devitalized tissue was removed to the level of healthy bleeding tissue which included biofilm and necrotic tissue. The instruments used included gauze scrub with cleanser. The debridement area extended down to the level of subcutaneous tissue. All surrounding periwound hyperkeratotic skin was also removed as required. Hemostasis was achieved by the usage of compression. The estimated blood loss was less than 3 ccs. The post-debridement measurements were as follows: W:1.2 x L:1.5 x D:0.3. The debridement area was cleansed with wound cleanser then dressed with a non-adherent dressing. The patient tolerated the procedure well and there were no complications. The patient was provided detailed post-procedure instructions. A follow-up appointment will be scheduled for approximately 1 week.",
                "sorting_order" => "3",
                "section_slug" => "procedure"
            ],
            [
                "section_title" => "Diagnosis",
                "section_text" => "L97918 Non-pressure chronic ulcer of unspecified part of right lower leg with other specified severity",
                "sorting_order" => "4",
                "section_slug" => "diagnosis"
            ],
            [
                "section_title" => "Treatment Order",
                "section_text" => "BLE wounds: Cleanse with wound cleanser, pat dry with gauze. Apply therahoney gel and alginate to the wound bed.Cover with bordered gauze dressing and wrap with rolled gauze 3x weekly or as needed for loose or soiled dressing. RX: Vitamin C 500mg PO daily.",
                "sorting_order" => "5",
                "section_slug" => "treatment_order"
            ],
            [
                "section_title" => "Care Plan/patients Instructions",
                "section_text" => "Encourage balanced diet with adequate protein (if not contraindicated), vitamins C and zinc to support tissue healing. -Monitor for any signs of systemic infection -avoid smoking and excessive alcohol consumption -emphasized importance of keeping skin clean and dry-Instructed on wound dressing change Educated on the potential complications such as cellulitis, osteomyelitis, or gangrene and seeking prompt medical attention if complications arise.-follow up with PCP and surgeon",
                "sorting_order" => "6",
                "section_slug" => "care_plan_patient_instructions"
            ],
        ];

        $template = new EncounterTemplate();
        $template->provider_id = auth()->user()->id;
        $template->patient_id = $encounter->patient_id;
        $template->encounter_id = $encounter->id;
        $template->template_name = 'wound';
        $template->encounter_template = json_encode($data);
        $template->save();
    }

    public function encounter_notes_store(Request $request)
    {
        $validatedData = $request->validate([
            'sections' => 'required|array',
        ]);

        $patient_id = $request->patient_id;

        DB::beginTransaction();

        try {
            foreach ($validatedData['sections'] as $sectionData) {
                $existingSection = EncounterNoteSection::where('id', $sectionData['sorting_order'])->first();

                if ($existingSection) {
                    if ($existingSection->section_slug == 'assessments') {
                        // Decode the JSON portion of the string
                        $jsonString = json_decode($existingSection->assessment_note, true);

                        if (json_last_error() === JSON_ERROR_NONE) {
                            foreach ($jsonString as &$data) {
                                Log::info('Checking value_id', [
                                    'data_value_id' => $data['value_id'], 'section_value_id' => $sectionData['value_id']
                                ]);

                                // Update assessment_input if value_id matches
                                if ($data['value_id'] == $sectionData['value_id']) {
                                    $data['assessment_input'] = $sectionData['assessment_input'];
                                }
                            }

                            // Encode the updated array back to JSON
                            $existingSection->assessment_note = json_encode($jsonString);
                        } else {
                            Log::error('JSON decoding error', ['error' => json_last_error_msg()]);
                        }

                        $existingSection->section_text = $sectionData['section_text'];
                        Log::info('Assessment Note Updated Successfully', ['section_id' => $existingSection->id]);
                    } else {
                        $existingSection->section_text = $sectionData['section_text'];
                        Log::info('Section Text Updated', ['section_id' => $existingSection->id]);
                    }

                    $existingSection->save();  // Save the updated section
                } else {
                    Log::warning('Encounter Note Section not found', ['section_id' => $sectionData['sorting_order']]);
                }
            }


            DB::commit();
            return response()->json(['message' => 'Sections updated successfully']);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error updating sections', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Failed to update sections'], 500);
        }
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $request->validate([
            'encounter_id' => 'required|exists:patient_encounters,id'
        ]);
        try {
            // Extract JSON data from the request
            $data = $request->json()->all();
            $encounter = PatientEncounter::findOrFail($request->encounter_id);
            if (isset($encounter)) {
                $encounter->update([
                    'encounter_date' => $request->signed_at,
                    'location' => $data['location'],
                    'reason' => $data['reason'],
                ]);
                return response()->json(['message' => 'Data updated successfully'], 200);
            } else {
                return response()->json(['message' => 'Record Not Found'], 200);

            }


        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($patient_id)
    {
        $data = PatientEncounter::leftjoin('list_options as encounter_type', 'encounter_type.id', '=',
            'patient_encounters.encounter_type')
            ->leftjoin('list_options as specialty', 'specialty.id', '=', 'patient_encounters.specialty')
            ->leftjoin('users as provider', 'provider.id', '=', 'patient_encounters.provider_id_patient')
            ->leftjoin('patients', 'patients.id', '=', 'patient_encounters.patient_id')
            ->leftjoin('facilities', 'facilities.id', '=', 'patient_encounters.location')
            ->select('patient_encounters.id', 'patient_encounters.provider_id',
                'patient_encounters.provider_id_patient', 'patient_encounters.patient_id',
                'patient_encounters.signed_by', 'patient_encounters.encounter_date',
                'patient_encounters.parent_encounter', 'patient_encounters.location', 'patient_encounters.reason',
                'patient_encounters.attachment', 'patient_encounters.status', 'patient_encounters.created_at',
                'patient_encounters.updated_at', 'encounter_type.title as encounter_type_title',
                'specialty.title as specialty_title', 'provider.name as provider_name', 'patients.mrn_no',
                'patients.date_of_birth', 'patients.gender', 'patient_encounters.pdf_make', 'patients.first_name',
                'patients.middle_name', 'patients.last_name', 'facilities.address as location')
            ->where('patient_id', $patient_id)
            ->orderBy('patient_encounters.created_at', 'DESC')
            ->get();
        foreach ($data as $reason) {
            $parts = [];
            if ($reason->status == '0') {
                $reason->status = 'draft';
            } else {
                $reason->status = 'assign';
            }
            if (!empty($reason->last_name)) {
                $parts[] = $reason->last_name;
            }

            if (!empty($reason->first_name)) {
                $parts[] = $reason->first_name;
            }

            if (!empty($reason->middle_name)) {
                $parts[] = ucfirst(substr($reason->middle_name, 0, 1));
            }

            $reason->patient_full_name = implode(', ', $parts);
        }

        $base = new BaseController();
        return $base->sendResponse($data, 'patients Encounter Fetched');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function encounter_notes($encounter_id)
    {
        $formattedData = [];
        $sections = EncounterNoteSection::where('encounter_id', $encounter_id)->orderBy('id', 'ASC')->get();
        $wounds = null;
        $wound_details = null;

        foreach ($sections as $key => $section) {
            $encounter = PatientEncounter::where('id', $encounter_id)->first();
            $check_speciality = ListOption::find($encounter->specialty);

            $wounds = Wound::where('encounter_id', $encounter_id)->first();
            // Fetch the wound record based on encounter ID
            $wounds = Wound::where('encounter_id', $encounter_id)->first();

            if (isset($wounds)) {
                // Fetch the wound details associated with the wound
                $wound_details = WoundDetails::where('wound_id', $wounds->id)->get();

                foreach ($wound_details as $wound_detail_data) {
                    $clinicalSigns = $wound_detail_data->clinical_signs_of_infection;

                    // Check if clinical_signs_of_infection is a string
                    if (is_string($clinicalSigns)) {
                        $clinicalSignsArray = json_decode($clinicalSigns, true);

                        // Check if json_decode returned an array
                        if (is_array($clinicalSignsArray)) {
                            $section_text = implode(",", $clinicalSignsArray);
                        } else {
                            // Handle the case where json_decode does not return an array
                            $section_text = $clinicalSigns; // or some default value
                        }
                    } else {
                        if (is_array($clinicalSigns)) {
                            // If clinical_signs_of_infection is already an array
                            $section_text = implode(",", $clinicalSigns);
                        } else {
                            // Handle the case where clinical_signs_of_infection is neither string nor array
                            $section_text = ''; // or some default value
                        }
                    }

                    $wound_detail_data->clinical_signs_of_infection = $section_text;
                }
            }


            $section_text = $section->section_text ?? '';

            if ($section['section_slug'] == 'review-of-systems') {
                $section_text = str_replace(
                    [
                        'General:', 'Skin:', 'Head:', 'Eyes:', 'Ears:', 'Nose:',
                        'Throat:', 'Neck:', 'Chest:', 'Respiratory:', 'Cardiovascular:',
                        'Gastrointestinal:',
                        'Genitourinary:', 'Musculoskeletal:', 'Neurological:', 'Psychiatric:', 'Endocrine:',
                        'Lymphatic:', 'Immunologic:'
                    ],
                    [
                        '<b>General:</b>', '<b>Skin:</b>', '<b>Head:</b>',
                        '<b>Eyes:</b>', '<b>Ears:</b>', '<b>Nose:</b>', '<b>Throat:</b>',
                        '<b>Neck:</b>', '<b>Chest:</b>', '<b>Respiratory:</b>', '<b>Cardiovascular:</b>',
                        '<b>Gastrointestinal:</b>',
                        '<b>Genitourinary:</b>', '<b>Musculoskeletal:</b>', '<b>Neurological:</b>',
                        '<b>Psychiatric:</b>',
                        '<b>Endocrine:</b>', '<b>Lymphatic:</b>', '<b>Immunologic:</b>',
                    ],
                    $section_text
                );
            }

            if ($section['section_slug'] == 'physical-exam') {
                $section_text = str_replace(
                    [
                        'Appearance:', 'Skin:', 'Head:', 'Eyes:', 'Ears:', 'Nose:', ' Throat:',
                        'Neck:', 'Chest:', 'Heart', 'Abdomen:', 'Genitourinary:', 'Musculoskeletal:',
                        'Neurological:', 'Psychiatric:'
                    ],
                    [
                        '<b>Appearance:</b>', '<b>Skin:</b>', '<b>Head:</b>', '<b>Neck:</b>', '<b>Eyes:</b>',
                        '<b>Ears:</b>',
                        '<b>Nose:</b>',
                        '<b> Throat:</b>', '<b>Neck:</b>', '<b>Chest:</b>', '<b>Heart:</b>',
                        '<b>Abdomen:</b>',
                        '<b>Genitourinary:</b>', '<b>Musculoskeletal:</b>', '<b>Neurological:</b>',
                        '<b>Psychiatric:</b>'
                    ],
                    $section_text
                );
            }

            if ($section['section_slug'] == 'assessments') {
                $section_text_2 = json_decode($section['assessment_note'], true);
            }

            if ($section['section_slug'] == 'mental_status_examination') {
                $section_text = str_replace(
                    [
                        'appearance:', 'alert:', 'behavior:', 'speech:', 'mood:', 'affect:',
                        'process:', 'content:', 'delusions:', 'suicidal_ideations:', 'homicidal_ideations:',
                        'aggressions:',
                        'Memory_Immediate:', 'recent:', 'retention_concentration:', 'impulse_control:', 'sleep:',
                        'appetite:', 'judgment:', 'insight:'
                    ],
                    [
                        '<b>appearance:</b>', '<b>alert:</b>', '<b>behavior:</b>',
                        '<b>speech:</b>', '<b>mood:</b>', '<b>affect:</b>', '<b>process:</b>',
                        '<b>content:</b>', '<b>delusions:</b>', '<b>suicidal_ideations:</b>',
                        '<b>homicidal_ideations:</b>',
                        '<b>aggressions:</b>',
                        '<b>Memory_Immediate:</b>', '<b>recent:</b>', '<b>retention_concentration:</b>',
                        '<b>impulse_control:</b>',
                        '<b>sleep:</b>', '<b>appetite:</b>', '<b>judgment:</b>', '<b>insight:</b>',
                    ],
                    $section_text
                );
            }

            if ($check_speciality->option_id == 'wound') {
                $section_text = str_replace('-', "\n", $section_text);
            }

            if ($section['section_slug'] == 'wound_evaluation') {

                $wound_details_array = [];
                if ($wound_details) {
                    foreach ($wound_details as $detail) {
                        $images = json_decode($detail->images, true);
                        $detail_array = $detail->toArray();
                        $detail_array['images'] = $images;
                        $wound_details_array[] = $detail_array;
                    }
                }
                $formattedData[] = [
                    'section_id' => $section->id,
                    'section_title' => $section->section_title,
                    'section_slug' => $section->section_slug,
                    'section_text' => $section_text,
                    'id_default' => (int) $section->sorting_order,
                    'section_type' => true,
                    'wound' => $wounds ?? [],
                    'wound_details' => $wound_details_array,
                ];
            } elseif ($section['section_slug'] == 'assessments') {
                $formattedData[] = [
                    'section_id' => $section->id,
                    'section_title' => $section->section_title,
                    'section_slug' => $section->section_slug,
                    'assessment_notes' => $section_text_2,
                    'section_text' => $section_text,
                    'id_default' => (int) $section->sorting_order,
                    'fixed_id' => 69,
                ];
            } elseif ($section['section_slug'] == 'mental_status_examination') {
                $formattedData[] = [
                    'section_id' => $section->id,
                    'section_title' => $section->section_title,
                    'section_slug' => $section->section_slug,
                    'section_text' => $section_text,
                    'id_default' => 100,
                    'fixed_id_mental' => 71,
                ];
            } else {
                $formattedSection = [
                    'section_id' => $section->id,
                    'section_title' => $section->section_title,
                    'section_slug' => $section->section_slug,
                    'section_text' => $section_text,
                    'id_default' => (int) $section->sorting_order,
                ];

                $formattedData[] = $formattedSection;
            }
        }

        return response()->json([
            'success' => true,
            'data' => $formattedData,
            'message' => 'Encounter note sections fetched successfully'
        ], 200);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        PatientEncounter::destroy($id);
        $base = new BaseController();
        return $base->sendResponse(null, 'patients Encounter Deleted');
    }

    public function patient_encounter_information($patient_id)
    {
        // Retrieve the 'initial-visit' option
        $initial_visit = ListOption::where('option_id', 'initial-visit')->first();

        // Check for patient encounters of type 'initial-visit'
        $check_patient_encounters = PatientEncounter::where('patient_id', $patient_id)
            ->where('encounter_type', $initial_visit->id)
            ->get();

        // Retrieve encounter types, excluding 'initial-visit' if needed
        if ($check_patient_encounters->isNotEmpty()) {
            $encounter_type = ListOption::where('list_id', 'Encounter Type')
                ->where('id', '!=', $initial_visit->id)
                ->select('id', 'title')
                ->get();
        } else {
            $encounter_type = ListOption::where('list_id', 'Encounter Type')
                ->select('id', 'title')
                ->get();
        }

        $existing_encounters = PatientEncounter::where('patient_encounters.patient_id',
            $patient_id)->leftjoin('facilities',
            'facilities.id', '=', 'patient_encounters.location')->select('patient_encounters.*',
            'facilities.address as location')->get();
        $providers = User::where('id', auth()->user()->id)->get();

        $Specialty = ListOption::where('list_id', 'Specialty')->select('id', 'title')->get();
        $facilities = DB::table('facilities')->select('id', 'name as address')->get();
        // Prepare fields' names from PatientEncounter table
        $encounter_fields = Schema::getColumnListing('patient_encounters');
        $loginProvider = User::where('id', auth()->user()->id)->select('name', 'id')->first();
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
                'facilities' => $facilities,
                'loginProvider' => $loginProvider
            ],
            200,
        );
    }


    public function status_update(Request $request)
    {
        $request->validate([
            'encounter_id' => 'required|exists:patient_encounters,id',
        ]);

        $encounter = PatientEncounter::findOrFail($request->encounter_id);
        $encounter_notes = EncounterNoteSection::where('encounter_id', $encounter->id)
            ->where('patient_id', $encounter->patient_id)
            ->get();
        $patient = Patient::findOrFail($encounter->patient_id);
        if ($encounter) {
            $check_speciality = ListOption::find($encounter->specialty);
            $today_date = \Carbon\Carbon::now()->format('d-M-Y');
            $encounterDate = \Carbon\Carbon::parse($encounter->encounter_date)->format('Y-m-d_H-i-s');
            $patientName = $patient->first_name.' '.$patient->last_name;
            $directoryPath = public_path('uploads');
            $fileName = "encounter_".now()->format('Y-m-d_H-i-s')."_patient_{$patientName}.pdf";
            $filePath = $directoryPath.'/'.$fileName;
            if (!file_exists($directoryPath)) {
                return '1';
                mkdir($directoryPath, 0777, true);
            }
            if ($check_speciality && $check_speciality->option_id == 'wound') {
                $wound = Wound::where('encounter_id', $encounter->id)->first();
                $woundDetails = $wound ? WoundDetails::where('wound_id',
                    $wound->id)->get() : collect();
                $pdf = PDF::loadView('PDF.wound_encounter_pdf',
                    compact('patient', 'encounter', 'encounter_notes', 'wound', 'woundDetails'));
            } elseif ($check_speciality && $check_speciality->option_id == 'psychiatrist') {
                $pdf = PDF::loadView('PDF.psychiatric_encounter_pdf',
                    compact('patient', 'encounter', 'encounter_notes'));
            } else {
                $pdf = PDF::loadView('PDF.general_encounter_pdf',
                    compact('patient', 'encounter', 'encounter_notes'));
            }
            $pdf->save($filePath);
            $encounter->pdf_make = $fileName;
            $encounter->status = '1';
            $encounter->save();

            return response()->json([
                'code' => 'success',
                'message' => 'Status Updated',
            ], 200);
        } else {
            return response()->json(['message' => 'No Encounter Found'], 404);
        }
    }


    public function check_patient_encounter($patient_id, $specialty_id)
    {
        // Retrieve the 'initial-visit' option
        $initial_visit = ListOption::where('option_id', 'initial-visit')->first();

        // Check for patient encounters of type 'initial-visit' with the specified specialty_id
        $check_patient_encounters = PatientEncounter::where('patient_id', $patient_id)
            ->where('encounter_type', $initial_visit->id)
            ->where('specialty', $specialty_id)
            ->get();

        // Retrieve encounter types, excluding 'initial-visit' if needed
        if ($check_patient_encounters->isNotEmpty()) {
            $encounter_type = ListOption::where('list_id', 'Encounter Type')
                ->where('id', '!=', $initial_visit->id)
                ->select('id', 'title')
                ->get();
        } else {
            $encounter_type = ListOption::where('list_id', 'Encounter Type')
                ->select('id', 'title')
                ->get();
        }

        return response()->json([
            'status' => true,
            'data' => $encounter_type
        ], 200);
    }


    public function mental_section_show($section_id, $patient_id)
    {
        // Fetch the data from the database
        $data = EncounterNoteSection::where('patient_id', $patient_id)
            ->where('id', $section_id)
            ->first();

        if (!$data) {
            return response()->json([
                'code' => 'error',
                'message' => 'No data found'
            ], 404);
        }

        $sectionsText = json_decode($data->section_json);

        return response()->json([
            'code' => 'success',
            'data' => $sectionsText
        ], 200);
    }


    public function psychiatric_update(Request $request)
    {
        $validatedData = $request->validate([
            'id' => 'required|exists:encounter_note_sections,id',
            'dataToUpdate' => 'required|array',
        ]);

        // Fetch the data from the database
        $data = EncounterNoteSection::where('id', $request->id)->first();

        if (!$data) {
            // Return error response if no data found
            return response()->json([
                'code' => 'error',
                'message' => 'No data found'
            ], 404);
        }

        // Get the payload data
        $payload = $request->input('dataToUpdate');

        // Initialize an empty string to hold the formatted section text
        $sectionText = '';

        // Iterate over each section and format it
        foreach ($payload as $key => $value) {
            // Convert array values to a comma-separated string
            if (is_array($value)) {
                $valueString = empty($value) ? 'N/A' : implode(', ', $value);
            } else {
                $valueString = $value;
            }
            $sectionText .= ucfirst($key).': '.$valueString.'<br><br>';
        }

        // Update the section text
        $data->section_text = $sectionText;
        $jsonData = json_encode($validatedData['dataToUpdate']);
        $data->section_json = $jsonData;
        // Save the changes
        $data->save();

        // Return success response
        return response()->json([
            'code' => 'success',
            'message' => 'Data updated successfully'
        ], 200);
    }


}
