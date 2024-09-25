<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEncounterRequest;
use App\Models\Allergy;
use App\Models\EncounterNoteSection;
use App\Models\EncounterTemplate;
use App\Models\ListOption;
use App\Models\medication;
use App\Models\patient;
use App\Models\PatientEncounter;
use App\Models\Problem;
use App\Models\User;
use App\Models\Vital;
use App\Models\Wound;
use App\Models\WoundDetails;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use PDF;

class Encountertest extends Controller
{
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
            $encounter_details = PatientEncounter::leftjoin('list_options as encounter_type', 'encounter_type.id', '=',
                'patient_encounters.encounter_type')
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
                    if ($existingTemplate->assessment_note != NULL) {
                        $existingTemplate->assessment_note = $existingTemplate->assessment_note;
                    }
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
        Log::info('Starting saveGeneralText for Encounter ID: ' . $encounter->id);

        // Fetch the template data
        $data = EncounterTemplate::where('template_name', 'general')->first();

        if (!$data) {
            Log::error('EncounterTemplate with template_name "general" not found.');
            return;
        }

        Log::info('Latest Encounter ID for same patient and specialty: ' . ($latest_encounter ? $latest_encounter->id : 'None'));

        foreach ($data->encounter_template as $key => $section) {
            $text = $section['section_text'];
            $text_2 = $section['section_text'];

            Log::info('Processing Section: ' . $section['section_slug']);

            // Handle special cases for specific sections
            if ($section['section_slug'] === 'physical-exam') {
                $text_2 = "Appearance: Well-nourished, well-developed, no acute distress.
            Skin: Warm, dry, intact, no rashes or lesions.
            Head: Normocephalic, atraumatic.
            Eyes: PERRLA (Pupils Equal, Round, Reactive to Light and Accommodation), EOMI (Extraocular Movements Intact), sclerae white, conjunctivae pink.
            Ears: Tympanic membranes intact, no erythema or discharge.
            Nose: Mucosa pink, no discharge, septum midline.
            Throat: Mucosa pink, no lesions, tonsils absent or not enlarged, uvula midline.
            Neck: No lymphadenopathy, thyroid non-palpable, trachea midline.
            Lungs: Clear to auscultation bilaterally, no wheezes, rales, or rhonchi.
            Heart: Regular rate and rhythm, no murmurs, gallops, or rubs.
            Abdomen: Soft, non-tender, no masses or organomegaly, bowel sounds normal.
            Genitourinary: No costovertebral angle tenderness.
            Musculoskeletal: Full range of motion, no joint swelling or deformity.
            Neurological: Alert and oriented x3, cranial nerves II-XII intact, motor strength 5/5, sensation intact, reflexes 2+ and symmetric.
            Psychiatric: Appropriate affect and behavior, normal mood and cognition, speech clear and coherent.";
                $text = str_replace("\n", "<br></br>", $text_2);
                $text = html_entity_decode($text);
            } elseif ($section['section_slug'] === 'review-of-systems') {
                $text_2 = "General: Denies weight loss, weight gain, or fatigue. Denies fever, chills, or night sweats.
            Skin: Denies rashes, itching, or changes in moles.
            Head: Denies headaches, dizziness, or trauma.
            Eyes: Denies vision changes, pain, redness, or discharge.
            Ears: Denies hearing loss, pain, tinnitus, or discharge.
            Nose: Denies congestion, discharge, nosebleeds, or sinus pain.
            Throat: Denies sore throat, difficulty swallowing, or hoarseness.
            Neck: Denies lumps, pain, or stiffness.
            Chest: Denies lumps, pain, or discharge.
            Respiratory: Denies cough, shortness of breath, or wheezing.
            Cardiovascular: Denies chest pain, palpitations, or edema.
            Gastrointestinal: Denies nausea, vomiting, diarrhea, or constipation.
            Genitourinary: Denies frequency, urgency, dysuria, or hematuria.
            Musculoskeletal: Denies joint pain, stiffness, or muscle weakness.
            Neurological: Denies numbness, tingling, weakness, or seizures.
            Psychiatric: Denies anxiety, depression, or sleep disturbances.
            Endocrine: Denies polyuria, polydipsia, or heat/cold intolerance.
            Lymphatic: Denies easy bruising, bleeding, or swollen glands.
            Immunologic: Denies allergies, frequent infections, or immunodeficiency.";
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
                Log::info($vital);
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

            // Attempt to copy old section text from the latest encounter if it exists
            if ($latest_encounter !== null) {
                Log::info('Fetching previous section for slug: ' . $section['section_slug']);
                $existingTemplate = EncounterNoteSection::where('encounter_id', $latest_encounter->id)
                    ->where('section_slug', $section['section_slug'])
                    ->first();

                if ($existingTemplate) {
                    Log::info('Existing Section Found for Slug: ' . $section['section_slug']);
                    Log::info('Existing Section Text: ' . $existingTemplate->section_text);
                    $newTemplate->section_text = $existingTemplate->section_text;
                    if ($existingTemplate->assessment_note != NULL) {
                        $existingTemplate->assessment_note = $existingTemplate->assessment_note;
                    }
                } else {
                    Log::info('No Existing Section Found for Slug: ' . $section['section_slug']);
                    $newTemplate->section_text = $section['section_slug'] === 'assessments' ? null : $text;
                }
            } else {
                Log::info('No Latest Encounter Found. Using Default Text');
                $newTemplate->section_text = $section['section_slug'] === 'assessments' ? null : $text;
            }

            $newTemplate->assessment_note = ($section['section_slug'] === 'assessments') ? $text_2 : null;

            // Save the new template section
            $newTemplate->save();
            Log::info('Saved Section for Slug: ' . $section['section_slug']);
        }

        Log::info('Completed saveGeneralText for Encounter ID: ' . $encounter->id);
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
                        'Appearance:', 'Skin:', 'Head:', 'Eyes:', 'Ears:', 'Nose:', ' Throat:', ' Lungs:',
                        'Neck:', 'Chest:', 'Heart', 'Abdomen:', 'Genitourinary:', 'Musculoskeletal:',
                        'Neurological:', 'Psychiatric:'
                    ],
                    [
                        '<b>Appearance:</b>', '<b>Skin:</b>', '<b>Head:</b>', '<b>Neck:</b>', '<b>Eyes:</b>',
                        '<b>Ears:</b>',
                        '<b>Nose:</b>',
                        '<b>Throat:</b>', '<b>Lungs:</b>', '<b>Neck:</b>', '<b>Chest:</b>', '<b>Heart:</b>',
                        '<b>Abdomen:</b>',
                        '<b>Genitourinary:</b>', '<b>Musculoskeletal:</b>', '<b>Neurological:</b>',
                        '<b>Psychiatric:</b>'
                    ],
                    $section_text
                );
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

    public function get_encounter($encounter_id)
    {
        $encounter = PatientEncounter::FindOrFail($encounter_id);
        if (isset($encounter)) {
            $encounter_details = PatientEncounter::leftjoin('list_options as encounter_type', 'encounter_type.id', '=',
                'patient_encounters.encounter_type')
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
            $formattedData = $this->showSections($encounter);
            return response()->json([
                'encounter_id' => $encounter->id,
                'encounter_details' => $encounter_details,
                'new_sections' => $formattedData,
            ], 201);
        } else {
            return response()->json([
                'success' => true,
                'message' => 'No Encounter found.',
            ], 404);
        }

    }

    public function get_pdf($id)
    {
        $encounter = PatientEncounter::findOrFail($id);
        if (isset($encounter)) {
            $check_speciality = ListOption::where('id', $encounter->specialty)->first();
            if (isset($check_speciality)) {
                $patient = Patient::findOrFail($encounter->patient_id);
                $user = User::with('details')->where('id', $encounter->provider_id)->first();
                $encounter_notes = EncounterNoteSection::where('encounter_id', $encounter->id)
                    ->where('patient_id', $encounter->patient_id)
                    ->where(function ($query) {
                        $query->whereNotNull('section_text')
                            ->where('section_text', '<>', '') // Ensure section_text is not empty
                            ->orWhere(function ($query) {
                                $query->whereNotNull('assessment_note')
                                    ->where(function ($query) {
                                        $query->whereRaw('LENGTH(assessment_note) > 2') // Ensure assessment_note is not an empty array
                                        ->whereRaw('LEFT(assessment_note, 1) = "["') // Check if it starts with "["
                                        ->whereRaw('RIGHT(assessment_note, 1) = "]"'); // Check if it ends with "]"
                                    });
                            });
                    })
                    ->get();


                if ($check_speciality->option_id == 'psychiatrist') {
                    $pdf = PDF::loadView('PDF.psychiatric_encounter_pdf',
                        compact('patient', 'encounter', 'encounter_notes', 'check_speciality', 'user'));
                } elseif ($check_speciality->option_id == 'wound') {
                    $wound = Wound::where('encounter_id', $encounter->id)->first();
                    $woundDetails = $wound ? WoundDetails::where('wound_id',
                        $wound->id)->get() : collect();
                    $pdf = PDF::loadView('PDF.wound_encounter_pdf',
                        compact('patient', 'encounter', 'encounter_notes', 'wound', 'woundDetails',
                            'check_speciality', 'user'));
                } else {
                    $pdf = PDF::loadView('PDF.general_encounter_pdf',
                        compact('patient', 'encounter', 'encounter_notes', 'check_speciality', 'user'));
                }
                $pdfContent = $pdf->output();
                $base64file = base64_encode($pdfContent);
                $mimeType = 'application/pdf';
                return response()->json([
                    'file' => $base64file,
                    'mime_type' => $mimeType
                ]);

            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Speciality Not Found'
                ], 404);
            }
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Encounter Not Found'
            ], 404);
        }
    }

    private function showPreviousSections($encounter)
    {
        Log::info('Previous Sections Load');
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
                        'Appearance:', 'Skin:', 'Head:', 'Eyes:', 'Ears:', 'Nose:', ' Throat:', ' Lungs:',
                        'Neck:', 'Chest:', 'Heart', 'Abdomen:', 'Genitourinary:', 'Musculoskeletal:',
                        'Neurological:', 'Psychiatric:'
                    ],
                    [
                        '<b>Appearance:</b>', '<b>Skin:</b>', '<b>Head:</b>', '<b>Neck:</b>', '<b>Eyes:</b>',
                        '<b>Ears:</b>',
                        '<b>Nose:</b>',
                        '<b>Throat:</b>', '<b>Lungs:</b>', '<b>Neck:</b>', '<b>Chest:</b>', '<b>Heart:</b>',
                        '<b>Abdomen:</b>',
                        '<b>Genitourinary:</b>', '<b>Musculoskeletal:</b>', '<b>Neurological:</b>',
                        '<b>Psychiatric:</b>'
                    ],
                    $section_text
                );
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

            if ($section['section_slug'] == 'assessments') {
                $section_text_2 = json_decode($section['assessment_note'], true);
                Log::info('Section Text of Assems: ' . json_encode($section_text));
            }

            if ($speciality->option_id == 'wound') {
                $section_text = str_replace('-', "\n", $section_text);
                Log::info($encounter->speciality);
            }

            if ($section['section_slug'] == 'wound_evaluation') {
                $formattedData[] = [
                    'section_id' => $section->id,
                    'section_title' => $section->section_title,
                    'section_slug' => $section->section_slug,
                    'section_text' => $section_text,
                    'id_default' => (int)$section->sorting_order,
                    'section_type' => true,
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

}
