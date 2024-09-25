<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController as BaseController;
use App\Http\Requests\StoreEncounterRequest;
use App\Models\Allergy;
use App\Models\EncounterNoteSection;
use App\Models\EncounterTemplate;
use App\Models\ListOption;
use App\Models\medication;
use App\Models\patient;
use App\Models\PatientEncounter;
use App\Models\Problem;
use App\Models\Vital;
use App\Models\Wound;
use App\Models\WoundDetails;
use Carbon\Carbon;
use Exception;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
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
    public function store(StoreEncounterRequest $request)
    {
        Log::info($request);
        try {
            $latest_encounter = PatientEncounter::where([
                'patient_id' => $request->patient_id,
                'specialty' => $request->specialty
            ])->latest()->first();

            $encounter = new PatientEncounter();
            $encounter->patient_id = $request->patient_id;
            $encounter->provider_id = auth()->user()->id;
            $encounter->provider_id_patient = $request->provider_id_patient;
            $formattedDate = $request->signed_at;
            $cleanedDateString = preg_replace('/\s*\(.*?\)/', '', $formattedDate);
            $date = date('Y-m-d H:i:s', strtotime($cleanedDateString));
            $encounter->encounter_date = $date ?? Carbon::now();
            $encounter->signed_by = auth()->user()->id;
            $encounter->encounter_type = $request->encounter_type;
            $encounter->specialty = $request->specialty;
            $encounter->parent_encounter = $request->parent_encounter;
            $encounter->location = current_facility(auth()->user()->id);
            $encounter->status = '0';
            $encounter->reason = $request->reason;
            $encounter->created_at = Carbon::now();
            $encounter->updated_at = Carbon::now();
            $encounter->save();
            Log::info('Encounter ID:' . $encounter->id);
            $this->handleVitalSigns($request, $encounter);
            $this->createEncounterSections($request, $encounter, $latest_encounter);
            $formattedData = $this->showSections($encounter);
            $encounter_details = PatientEncounter::leftjoin(
                'list_options as encounter_type',
                'encounter_type.id',
                '=',
                'patient_encounters.encounter_type'
            )
                ->leftjoin('list_options as specialty', 'specialty.id', '=', 'patient_encounters.specialty')
                ->leftjoin('users as provider', 'provider.id', '=', 'patient_encounters.provider_id_patient')
                ->leftjoin('patients', 'patients.id', '=', 'patient_encounters.patient_id')
                ->select(
                    'patient_encounters.id',
                    'patient_encounters.provider_id',
                    'patient_encounters.provider_id_patient',
                    'patient_encounters.patient_id',
                    'patient_encounters.signed_by',
                    'patient_encounters.encounter_date',
                    'patient_encounters.parent_encounter',
                    'patient_encounters.location',
                    'patient_encounters.reason',
                    'patient_encounters.attachment',
                    'patient_encounters.status',
                    'patient_encounters.created_at',
                    'patient_encounters.updated_at',
                    'encounter_type.title as encounter_type_title',
                    'specialty.title as specialty_title',
                    'provider.name as provider_name',
                    'patients.mrn_no',
                    'patients.first_name',
                    'patients.middle_name',
                    'patients.last_name',
                    'patients.date_of_birth',
                    'patients.gender'
                )
                ->where('patient_encounters.id', $encounter->id)
                ->first();
            $parts = [];
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

            $response = [
                'success' => true,
                'data' => $formattedData,
                'wound' => null,
                'wound_details' => null,
                'message' => 'Encounter note sections fetched successfully',
            ];
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    private function handleVitalSigns(Request $request, $encounter)
    {
        if ($request->skip != 'true') {
            $vital = new Vital();
            $formattedDate = $request->signed_at;
            $cleanedDateString = preg_replace('/\s*\(.*?\)/', '', $formattedDate);
            $date = date('Y-m-d H:i:s', strtotime($cleanedDateString));
            $vital->date = $date ?? Carbon::now();
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

    private function createEncounterSections(Request $request, $encounter, $latest_encounter)
    {
        $check_speciality = ListOption::where('id', $encounter->specialty)->first();
        if ($check_speciality->option_id == 'psychiatrist') {
            $this->savePsychiatristText($encounter, $latest_encounter);
        } elseif ($check_speciality->option_id == 'wound') {
            $this->saveWoundText($encounter, $latest_encounter);
        } else {
            $this->saveGeneralText($encounter, $latest_encounter);
        }
    }

    private function savePsychiatristText($encounter, $latest_encounter)
    {
        Log::info('Starting savePsychiatristText for Encounter ID: ' . $encounter->id);

        // Fetch the psychiatrist template data
        $data = EncounterTemplate::where('template_name', 'psychiatrist')->first();

        if (!$data) {
            Log::error('EncounterTemplate with template_name "psychiatrist" not found.');
            return;
        }
        Log::info('Latest Encounter ID for same patient and specialty: ' . ($latest_encounter ? $latest_encounter->id : 'None'));

        foreach ($data->encounter_template as $key => $section) {
            $text = $section['section_text'];
            $text_2 = null;
            $text_json = null;

            // Default mental status examination text
            if ($section['section_slug'] === 'mental_status_examination') {
                $text_2 = "appearance: Kempt<br></br>
            alert: Yes<br></br>
            behavior: Normal<br></br>
            speech: Verbal<br></br>
            mood: Euthymic<br></br>
            affect: Appropriate<br></br>
            process: Intact<br></br>
            content: Denied<br></br>
            delusions: Denied<br></br>
            suicidal_ideations: No<br></br>
            homicidal_ideations: No<br></br>
            aggressions: No<br></br>
            Memory_Immediate: Intact<br></br>
            recent: Intact<br></br>
            retention_concentration: Good<br></br>
            impulse_control: Adequate<br></br>
            sleep: Normal<br></br>
            appetite: Normal<br></br>
            judgment: Adequate<br></br>
            insight: Adequate";

                $text = html_entity_decode($text_2);
                $text_json = json_encode([
                    "appearance" => ["Kempt"],
                    "alert" => ["Yes"],
                    "behavior" => ["Normal"],
                    "speech" => ["Verbal"],
                    "mood" => ["Euthymic"],
                    "affect" => ["Appropriate"],
                    "process" => ["Intact"],
                    "content" => ["Denied"],
                    "delusions" => ["Denied"],
                    "suicidal_ideations" => ["No"],
                    "homicidal_ideations" => ["No"],
                    "aggressions" => ["No"],
                    "Memory_Immediate" => ["Intact"],
                    "recent" => ["Intact"],
                    "retention_concentration" => ["Good"],
                    "impulse_control" => ["Adequate"],
                    "sleep" => ["Normal"],
                    "appetite" => ["Normal"],
                    "judgment" => ["Adequate"],
                    "insight" => ["Adequate"]
                ], JSON_PRETTY_PRINT);
            } elseif ($section['section_slug'] === 'assessments') {
                $text_2 = [];
                $problems = Problem::where('patient_id', $encounter->patient_id)
                    ->where('encounter_id', $encounter->id)
                    ->get();
                Log::info('Problems for patient ID ' . $encounter->patient_id . ': ' . $problems);

                foreach ($problems as $problem) {
                    $text_2[] = [
                        'Code' => $problem->diagnosis,
                        'Description' => $problem->name,
                        'assessment_input' => "",
                        'value_id' => rand(123456, 999999),
                    ];
                }
                $text_2 = json_encode($text_2, JSON_PRETTY_PRINT);
            }

            // Check if latest encounter exists
            if ($latest_encounter) {
                // Copy section text from the latest encounter
                $existingTemplate = EncounterNoteSection::where('encounter_id', $latest_encounter->id)
                    ->where('section_slug', $section['section_slug'])
                    ->first();

                if ($existingTemplate) {
                    $text = $existingTemplate->section_text;
                    $text_json = $existingTemplate->section_json;
                    $text_2 = $existingTemplate->assessment_note;
                }
            }

            // Create new EncounterNoteSection with the copied or default text
            $template = new EncounterNoteSection();
            $template->provider_id = auth()->user()->id;
            $template->patient_id = $encounter->patient_id;
            $template->encounter_id = $encounter->id;
            $template->section_title = $section['section_title'];
            $template->section_slug = $section['section_slug'];
            $template->sorting_order = $key + 1;
            $template->section_text = $section['section_slug'] === 'assessments' ? null : $text;
            $template->section_json = $text_json;
            $template->assessment_note = $section['section_slug'] === 'assessments' ? $text_2 : null;
            $template->save();

            Log::info('Processed Section for Slug: ' . $section['section_slug']);
        }

        Log::info('Completed savePsychiatristText for Encounter ID: ' . $encounter->id);
    }


    private function saveWoundText($encounter, $latest_encounter)
    {
        Log::info('Starting saveWoundText for Encounter ID: ' . $encounter->id);

        // Fetch the wound template data
        $data = EncounterTemplate::where('template_name', 'wound')->first();

        if (!$data) {
            Log::error('EncounterTemplate with template_name "wound" not found.');
            return;
        }

        // Process each section in the template
        foreach ($data->encounter_template as $key => $section) {
            $text = $section['section_text'] ?? null;

            if ($section['section_slug'] === 'assessments') {
                $text = [];
                $problems = Problem::where('patient_id', $encounter->patient_id)
                    ->where('encounter_id', $encounter->id)
                    ->get();

                Log::info('Problems for patient ID ' . $encounter->patient_id . ': ' . $problems);

                foreach ($problems as $problem) {
                    $text[] = [
                        'Code' => $problem->diagnosis,
                        'Description' => $problem->name,
                        'assessment_input' => "",
                        'value_id' => rand(123456, 999999),
                    ];
                }
                $text = json_encode($text, JSON_PRETTY_PRINT);
            }

            // Check if there's a latest encounter
            if ($latest_encounter) {
                Log::info('Copying section text from latest encounter ID: ' . $latest_encounter->id);

                $existingTemplate = EncounterNoteSection::where('encounter_id', $latest_encounter->id)
                    ->where('section_slug', $section['section_slug'])
                    ->first();

                if ($existingTemplate) {
                    $text = $existingTemplate->section_text;
                    Log::info('Copied section text for Slug: ' . $section['section_slug']);
                } else {
                    Log::warning('No existing section found for Slug: ' . $section['section_slug'] . ' in latest encounter.');
                }
            }

            $newSection = new EncounterNoteSection();
            $newSection->provider_id = auth()->user()->id;
            $newSection->patient_id = $encounter->patient_id;
            $newSection->encounter_id = $encounter->id;
            $newSection->section_title = $section['section_title'];
            $newSection->section_slug = $section['section_slug'];
            $newSection->sorting_order = $key + 1;
            $newSection->section_text = $section['section_slug'] === 'assessments' ? null : $text;
            $newSection->assessment_note = $section['section_slug'] === 'assessments' ? $text : null;
            $newSection->save();

            Log::info('Created/Updated Section for Slug: ' . $section['section_slug']);
        }

        $existingWound = Wound::where('encounter_id', $latest_encounter->id ?? null)->first();

        if ($existingWound) {
            Log::info('Duplicating Wound Record for Encounter ID: ' . $encounter->id);

            // Duplicate the wound record
            $newWound = $existingWound->replicate();
            $newWound->encounter_id = $encounter->id; // Associate with the current encounter
            $newWound->save();

            // Fetch and duplicate wound details associated with the existing wound
            $existingWoundDetails = WoundDetails::where('wound_id', $existingWound->id)->get();
            foreach ($existingWoundDetails as $existingDetail) {
                $newDetail = $existingDetail->replicate();
                $newDetail->wound_id = $newWound->id; // Associate with the new wound record
                $newDetail->save();
            }

            Log::info('Duplicated Wound Record and Details for Encounter ID: ' . $encounter->id);
        } else {
            Log::warning('No existing wound record found for the latest encounter.');
        }

        Log::info('Completed saveWoundText for Encounter ID: ' . $encounter->id);
    }


    private function saveGeneralText($encounter, $latest_encounter)
    {
        $data = EncounterTemplate::where('template_name', 'general')->first();
        if (!$data) {
            Log::error('EncounterTemplate with template_name "general" not found.');
            return;
        }
        foreach ($data->encounter_template as $key => $section) {
            $text = $section['section_text'];
            $text_2 = $section['section_text'];
            if ($section['section_slug'] === 'physical-exam') {
                $text_2 = physical_exam_text();
                $text = str_replace("\n", "<br></br>", $text_2);
                $text = html_entity_decode($text);
            } elseif ($section['section_slug'] === 'review-of-systems') {
                $text_2 = review_of_symstem_text();
                $text = str_replace("\n", "<br></br>", $text_2);
                $text = html_entity_decode($text);
            } elseif ($section['section_slug'] === 'allergies') {
                $allergy = Allergy::where('patient_id', $encounter->patient_id)->latest()->first();
                $text = null;
                if (isset($allergy)) {
                    $allergy_type = ListOption::where('id', $allergy->allergy_type)->first();
                    $text = $allergy->allergy . ' - ' . $allergy_type->title;
                }
            } elseif ($section['section_slug'] === 'medications') {
                $medication = Medication::where('patient_id', $encounter->patient_id)->latest()->first();
                $text = null;
                if (isset($medication)) {
                    $text = $medication->title;
                    if (!empty($medication->dose) && !empty($medication->dosage_unit)) {
                        $text .= ' - ' . $medication->dose . ' ' . $medication->dosage_unit;
                    }
                    if (!empty($medication->quantity)) {
                        $text .= ', ' . $medication->quantity;
                    }
                    if (!empty($medication->frequency)) {
                        $text .= ' (' . $medication->frequency . ')';
                    }
                }
            } elseif ($section['section_slug'] === 'vital-sign') {
                $vital = Vital::where('patient_id', $encounter->patient_id)->latest()->first();
                $text = null;
                if (isset($vital)) {
                    $text = '';
                    if (!empty($vital->date)) {
                        $text .= $vital->date . ' - ' . $vital->bmi_in . "\n\n";
                    }
                    if (!empty($vital->blood_pressure)) {
                        $text .= 'BP: ' . $vital->blood_pressure . "\n\n";
                    }
                    if (!empty($vital->height_in)) {
                        $text .= 'Height (in): ' . $vital->height_in . "\n\n";
                    }
                    if (!empty($vital->weight_lbs)) {
                        $text .= 'Weight (lb): ' . $vital->weight_lbs . "\n\n";
                    }
                    if (!empty($vital->bmi_in)) {
                        $text .= 'BMI Interp: ' . $vital->bmi_in . "\n\n";
                    }
                    if (!empty($vital->body_temp_result_f)) {
                        $text .= 'Temp (F): ' . $vital->body_temp_result_f . '°F' . "\n\n";
                    }
                    if (!empty($vital->pulse_beats_in)) {
                        $text .= 'Pulse (beats/min): ' . $vital->pulse_beats_in . "\n\n";
                    }
                    if (!empty($vital->resp_rate)) {
                        $text .= 'Resp Rate (breaths/min): ' . $vital->resp_rate . "\n\n";
                    }
                    if (!empty($vital->waist_in)) {
                        $text .= 'Waist (in): ' . $vital->waist_in . "\n\n";
                    }
                    if (!empty($vital->glucose)) {
                        $text .= 'Glucose: ' . $vital->glucose . "\n\n";
                    }
                }
            } elseif ($section['section_slug'] === 'assessments') {
                $text2 = [];
                $problems = Problem::where('patient_id', $encounter->patient_id)
                    ->where('encounter_id', $encounter->id)
                    ->get();
                foreach ($problems as $problem) {
                    $text2[] = [
                        'Code' => $problem->diagnosis,
                        'Description' => $problem->name,
                        'assessment_input' => "",
                        'value_id' => rand(123456, 999999),
                    ];
                }
                $text_2 = json_encode($text2, JSON_PRETTY_PRINT);
            }

            $newTemplate = new EncounterNoteSection();
            $newTemplate->provider_id = auth()->user()->id;
            $newTemplate->patient_id = $encounter->patient_id;
            $newTemplate->encounter_id = $encounter->id;
            $newTemplate->section_title = $section['section_title'];
            $newTemplate->section_slug = $section['section_slug'];
            $newTemplate->sorting_order = $key + 1;
            if ($latest_encounter !== null) {
                $existingTemplate = EncounterNoteSection::where('encounter_id', $latest_encounter->id)
                    ->where('section_slug', $section['section_slug'])
                    ->first();
                $september19 = \Carbon\Carbon::createFromDate(2023, 9, 19);
                if ($existingTemplate) {
                    if ($existingTemplate->created_at->lessThan($september19)) {
                        $newTemplate->section_text = $section['section_slug'] === 'assessments' ? null : $text;
                    } else {
                        $newTemplate->section_text = $existingTemplate->section_text;
                    }
                } else {
                    $newTemplate->section_text = $section['section_slug'] === 'assessments' ? null : $text;
                }
            } else {
                $newTemplate->section_text = $section['section_slug'] === 'assessments' ? null : $text;
            }

            $newTemplate->assessment_note = ($section['section_slug'] === 'assessments') ? $text_2 : null;
            $newTemplate->save();
        }
    }


    private function showSections($encounter)
    {
        Log::info('New Section Encounter ID:' . $encounter->id);
        $formattedData = [];
        $sections = EncounterNoteSection::where('encounter_id', $encounter->id)->orderBy('id', 'ASC')->get();
        foreach ($sections as $key => $section) {
            $speciality = ListOption::where('id', $encounter->specialty)->first();
            $encounter = PatientEncounter::where('id', $encounter->id)->first();
            if ($encounter->speciality == 'psychiatrist') {
                $fixed_id = 69;
            }

            $section_text = $section->section_text ?? '';

            if ($section['section_slug'] == 'review-of-systems') {
                $section_text = str_replace(
                    [
                        'General:',
                        'Skin:',
                        'Head:',
                        'Eyes:',
                        'Ears:',
                        'Nose:',
                        'Mouth/Throat:',
                        'Neck:',
                        'Breasts/Chest:',
                        'Respiratory:',
                        'Cardiovascular:',
                        'Gastrointestinal:',
                        'Genitourinary:',
                        'Musculoskeletal:',
                        'Neurological:',
                        'Psychiatric:',
                        'Endocrine:',
                        'Hematologic/Lymphatic:',
                        'Allergic/Immunologic:'
                    ],
                    [
                        '<b>General:</b>',
                        '<b>Skin:</b>',
                        '<b>Head:</b>',
                        '<b>Eyes:</b>',
                        '<b>Ears:</b>',
                        '<b>Nose:</b>',
                        '<b>Mouth/Throat:</b>',
                        '<b>Neck:</b>',
                        '<b>Breasts/Chest:</b>',
                        '<b>Respiratory:</b>',
                        '<b>Cardiovascular:</b>',
                        '<b>Gastrointestinal:</b>',
                        '<b>Genitourinary:</b>',
                        '<b>Musculoskeletal:</b>',
                        '<b>Neurological:</b>',
                        '<b>Psychiatric:</b>',
                        '<b>Endocrine:</b>',
                        '<b>Hematologic/Lymphatic:</b>',
                        '<b>Allergic/Immunologic:</b>',
                    ],
                    $section_text
                );
            }

            if ($section['section_slug'] == 'physical-exam') {
                $section_text = str_replace(
                    [
                        'Appearance:',
                        'Skin:',
                        'Head:',
                        'Eyes:',
                        'Ears:',
                        'Nose:',
                        ' Mouth/Throat:',
                        ' Lungs:',
                        'Neck:',
                        'Chest/Lungs:',
                        'Heart',
                        'Abdomen:',
                        'Genitourinary:',
                        'Musculoskeletal:',
                        'Neurological:',
                        'Psychiatric:'
                    ],
                    [
                        '<b>Appearance:</b>',
                        '<b>Skin:</b>',
                        '<b>Head:</b>',
                        '<b>Neck:</b>',
                        '<b>Eyes:</b>',
                        '<b>Ears:</b>',
                        '<b>Nose:</b>',
                        '<b>Mouth/Throat:</b>',
                        '<b>Lungs:</b>',
                        '<b>Neck:</b>',
                        '<b>Chest/Lungs:</b>',
                        '<b>Heart:</b>',
                        '<b>Abdomen:</b>',
                        '<b>Genitourinary:</b>',
                        '<b>Musculoskeletal:</b>',
                        '<b>Neurological:</b>',
                        '<b>Psychiatric:</b>'
                    ],
                    $section_text
                );
            }

            if ($section['section_slug'] == 'mental_status_examination') {
                $section_text = str_replace(
                    [
                        'appearance:',
                        'alert:',
                        'behavior:',
                        'speech:',
                        'mood:',
                        'affect:',
                        'process:',
                        'content:',
                        'delusions:',
                        'suicidal_ideations:',
                        'homicidal_ideations:',
                        'aggressions:',
                        'Memory_Immediate:',
                        'recent:',
                        'retention_concentration:',
                        'impulse_control:',
                        'sleep:',
                        'appetite:',
                        'judgment:',
                        'insight:'
                    ],
                    [
                        '<b>appearance:</b>',
                        '<b>alert:</b>',
                        '<b>behavior:</b>',
                        '<b>speech:</b>',
                        '<b>mood:</b>',
                        '<b>affect:</b>',
                        '<b>process:</b>',
                        '<b>content:</b>',
                        '<b>delusions:</b>',
                        '<b>suicidal_ideations:</b>',
                        '<b>homicidal_ideations:</b>',
                        '<b>aggressions:</b>',
                        '<b>Memory_Immediate:</b>',
                        '<b>recent:</b>',
                        '<b>retention_concentration:</b>',
                        '<b>impulse_control:</b>',
                        '<b>sleep:</b>',
                        '<b>appetite:</b>',
                        '<b>judgment:</b>',
                        '<b>insight:</b>',
                    ],
                    $section_text
                );
            }

            if ($section['section_slug'] == 'assessments') {
                $section_text_2 = json_decode($section['assessment_note'], true);
                Log::info('Section Text of Assems: ' . json_encode($section_text));
            }

            if ($speciality->option_id == 'wound') {
                $section_text = str_replace('-', "\n", $section_text);
                Log::info($encounter->speciality);
            }

            // Fetch the wound record
            $wound = Wound::where('encounter_id', $encounter->id)->first();

            // Initialize variables to handle cases where $wound is null
            $other_factors_string = '';
            $patient_education_string = '';
            $wound_details = [];

            // Check if a wound record was found
            if ($wound) {
                // Decode JSON fields if $wound is not null
                $other_factors = json_decode($wound->other_factor);
                $patient_education = json_decode($wound->patient_education);

                // Handle potential decoding issues
                $other_factors = is_array($other_factors) ? $other_factors : [];
                $patient_education = is_array($patient_education) ? $patient_education : [];

                // Convert arrays to comma-separated strings
                $other_factors_string = implode(',', $other_factors);
                $patient_education_string = implode(',', $patient_education);

                // Assign formatted strings back to the wound object
                $wound->patient_education = $patient_education_string;
                $wound->other_factor = $other_factors_string;
                $wound->other_factor_title = $wound->other_factor;
                $wound->patient_education_title = $wound->patient_education;

                // Fetch related wound details
                $wound_details = WoundDetails::where('wound_id', $wound->id)->get();
                foreach ($wound_details as $wound_detail) {
                    $clinical_signs_of_infection = json_decode($wound_detail->clinical_signs_of_infection);
                    // Handle potential decoding issues
                    $clinical_signs_of_infection = is_array($clinical_signs_of_infection) ? $clinical_signs_of_infection : [];
                    // Convert arrays to comma-separated strings
                    $clinical_signs_of_infection_string = implode(',', $clinical_signs_of_infection);
                    // Assign formatted strings back to the wound object
                    $wound_detail->clinical_signs_of_infection = $clinical_signs_of_infection_string;
                    $wound_detail->clinical_signs_of_infection_title = $wound_detail->clinical_signs_of_infection;
                    $wound_detail->images = json_encode($wound_detail->images, true);
                }
            }

            if ($section['section_slug'] == 'wound_evaluation') {
                $formattedData[] = [
                    'section_id' => $section->id,
                    'section_title' => $section->section_title,
                    'section_slug' => $section->section_slug,
                    'section_text' => $section_text,
                    'id_default' => (int)$section->sorting_order,
                    'section_type' => true,
                    'wound' => $wound ?? [],
                    'wound_details' => $wound_details,
                ];
            } elseif ($section['section_slug'] == 'assessments') {
                $formattedData[] = [
                    'section_id' => $section->id,
                    'section_title' => $section->section_title,
                    'section_slug' => $section->section_slug,
                    'section_text' => $section_text,
                    'assessment_notes' => $section_text_2,
                    'id_default' => (int)$section->sorting_order,
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
                    'id_default' => (int)$section->sorting_order,
                ];

                $formattedData[] = $formattedSection;
            }
        }

        return $formattedData;
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
                                    'data_value_id' => $data['value_id'],
                                    'section_value_id' => $sectionData['value_id']
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
        } catch (Exception $e) {
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
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($patient_id)
    {
        $data = PatientEncounter::leftjoin(
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
                'patient_encounters.id',
                'patient_encounters.provider_id',
                'patient_encounters.provider_id_patient',
                'patient_encounters.patient_id',
                'patient_encounters.signed_by',
                'patient_encounters.encounter_date',
                'patient_encounters.parent_encounter',
                'patient_encounters.location',
                'patient_encounters.reason',
                'patient_encounters.attachment',
                'patient_encounters.status',
                'patient_encounters.created_at',
                'patient_encounters.updated_at',
                'encounter_type.title as encounter_type_title',
                'specialty.title as specialty_title',
                'provider.name as provider_name',
                'patients.mrn_no',
                'patients.date_of_birth',
                'patients.gender',
                'patient_encounters.pdf_make',
                'patients.first_name',
                'patients.middle_name',
                'patients.last_name',
                'facilities.address as location'
            )
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
                        'General:',
                        'Skin:',
                        'Head:',
                        'Eyes:',
                        'Ears:',
                        'Nose:',
                        'Mouth/Throat:',
                        'Neck:',
                        'Breasts/Chest:',
                        'Respiratory:',
                        'Cardiovascular:',
                        'Gastrointestinal:',
                        'Genitourinary:',
                        'Musculoskeletal:',
                        'Neurological:',
                        'Psychiatric:',
                        'Endocrine:',
                        'Hematologic/Lymphatic:',
                        'Allergic/Immunologic:'
                    ],
                    [
                        '<b>General:</b>',
                        '<b>Skin:</b>',
                        '<b>Head:</b>',
                        '<b>Eyes:</b>',
                        '<b>Ears:</b>',
                        '<b>Nose:</b>',
                        '<b>Mouth/Throat:</b>',
                        '<b>Neck:</b>',
                        '<b>Breasts/Chest:</b>',
                        '<b>Respiratory:</b>',
                        '<b>Cardiovascular:</b>',
                        '<b>Gastrointestinal:</b>',
                        '<b>Genitourinary:</b>',
                        '<b>Musculoskeletal:</b>',
                        '<b>Neurological:</b>',
                        '<b>Psychiatric:</b>',
                        '<b>Endocrine:</b>',
                        '<b>Hematologic/Lymphatic:</b>',
                        '<b>Allergic/Immunologic:</b>',
                    ],
                    $section_text
                );
            }

            if ($section['section_slug'] == 'physical-exam') {
                $section_text = str_replace(
                    [
                        'Appearance:',
                        'Skin:',
                        'Head:',
                        'Eyes:',
                        'Ears:',
                        'Nose:',
                        'Mouth/Throat:',
                        'Lungs:',
                        'Neck:',
                        'Chest/Lungs:',
                        'Heart',
                        'Abdomen:',
                        'Genitourinary:',
                        'Musculoskeletal:',
                        'Neurological:',
                        'Psychiatric:'
                    ],
                    [
                        '<b>Appearance:</b>',
                        '<b>Skin:</b>',
                        '<b>Head:</b>',
                        '<b>Neck:</b>',
                        '<b>Eyes:</b>',
                        '<b>Ears:</b>',
                        '<b>Nose:</b>',
                        '<b>Mouth/Throat:</b>',
                        '<b>Lungs:</b>',
                        '<b>Neck:</b>',
                        '<b>Chest/Lungs:</b>',
                        '<b>Heart:</b>',
                        '<b>Abdomen:</b>',
                        '<b>Genitourinary:</b>',
                        '<b>Musculoskeletal:</b>',
                        '<b>Neurological:</b>',
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
                        'appearance:',
                        'alert:',
                        'behavior:',
                        'speech:',
                        'mood:',
                        'affect:',
                        'process:',
                        'content:',
                        'delusions:',
                        'suicidal_ideations:',
                        'homicidal_ideations:',
                        'aggressions:',
                        'Memory_Immediate:',
                        'recent:',
                        'retention_concentration:',
                        'impulse_control:',
                        'sleep:',
                        'appetite:',
                        'judgment:',
                        'insight:'
                    ],
                    [
                        '<b>appearance:</b>',
                        '<b>alert:</b>',
                        '<b>behavior:</b>',
                        '<b>speech:</b>',
                        '<b>mood:</b>',
                        '<b>affect:</b>',
                        '<b>process:</b>',
                        '<b>content:</b>',
                        '<b>delusions:</b>',
                        '<b>suicidal_ideations:</b>',
                        '<b>homicidal_ideations:</b>',
                        '<b>aggressions:</b>',
                        '<b>Memory_Immediate:</b>',
                        '<b>recent:</b>',
                        '<b>retention_concentration:</b>',
                        '<b>impulse_control:</b>',
                        '<b>sleep:</b>',
                        '<b>appetite:</b>',
                        '<b>judgment:</b>',
                        '<b>insight:</b>',
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
                    'id_default' => (int)$section->sorting_order,
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
                    'id_default' => (int)$section->sorting_order,
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
                    'id_default' => (int)$section->sorting_order,
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

        $existing_encounters = PatientEncounter::where(
            'patient_encounters.patient_id',
            $patient_id
        )->leftjoin(
            'facilities',
            'facilities.id',
            '=',
            'patient_encounters.location'
        )->select(
            'patient_encounters.*',
            'facilities.address as location'
        )->get();
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
            $sectionText .= ucfirst($key) . ': ' . $valueString . '<br><br>';
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

    public function pastPatientEncounters()
    {
        $data = PatientEncounter::leftjoin(
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
                'patients.id',
                'patient_encounters.provider_id',
                'patient_encounters.provider_id_patient',
                'patient_encounters.patient_id',
                'patient_encounters.signed_by',
                'patient_encounters.encounter_date',
                'patient_encounters.parent_encounter',
                'patient_encounters.location',
                'patient_encounters.reason',
                'patient_encounters.attachment',
                'patient_encounters.status',
                'patient_encounters.created_at',
                'patient_encounters.updated_at',
                'encounter_type.title as encounter_type_title',
                'specialty.title as specialty_title',
                'provider.name as provider_name',
                'patients.mrn_no',
                'patients.date_of_birth',
                'patients.gender',
                'patient_encounters.pdf_make',
                'patients.first_name',
                'patients.middle_name',
                'patients.last_name',
                'patients.medical_no',
                'facilities.name as facility_name',
                'patients.profile_pic',
            )
            ->where('patient_encounters.provider_id', auth()->user()->id)
            ->orderBy('patient_encounters.created_at', 'DESC')
            ->get();

        foreach ($data as $reason) {
            $parts = [];
            if ($reason->status == '0') {
                $reason->status = 'Draft';
            } else {
                $reason->status = 'Signed';
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
}
