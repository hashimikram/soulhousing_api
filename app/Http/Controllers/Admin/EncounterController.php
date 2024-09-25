<?php

namespace App\Http\Controllers\Admin;

use App\Exports\EncounterExport;
use App\Http\Controllers\Controller;
use App\Models\EncounterNoteSection;
use App\Models\ListOption;
use App\Models\patient;
use App\Models\PatientEncounter;
use App\Models\User;
use App\Models\Wound;
use App\Models\WoundDetails;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class EncounterController extends Controller
{
    public function index(Request $request)
    {
        $query = PatientEncounter::with([
            'provider',
            'providerPatient',
            'patient',
            'signedBy',
            'encounterType',
            'specialty_type',
            'parentEncounter',
            'facility'
        ]);

        // Normalize input data
        $firstName = $request->input('first_name');
        $lastName = $request->input('last_name');
        $specialtyId = $request->input('specialty');
        $providerId = $request->input('provider');
        $facilityId = $request->input('facility');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        // Apply filters based on the request
        if (!empty($firstName)) {
            $query->whereHas('patient', function ($q) use ($firstName) {
                $q->whereRaw('LOWER(first_name) LIKE ?', ['%' . strtolower(trim($firstName)) . '%']);
            });
        }

        if (!empty($lastName)) {
            $query->whereHas('patient', function ($q) use ($lastName) {
                $q->whereRaw('LOWER(last_name) LIKE ?', ['%' . strtolower(trim($lastName)) . '%']);
            });
        }

        if (!empty($providerId)) {
            $query->whereHas('provider', function ($q) use ($providerId) {
                $q->where('id', $providerId);
            });
        }

        if (!empty($specialtyId)) {
            $query->whereHas('specialty_type', function ($q) use ($specialtyId) {
                $q->where('id', $specialtyId);
            });
        }

        if (!empty($facilityId)) {
            $query->whereHas('facility', function ($q) use ($facilityId) {
                $q->where('id', $facilityId);
            });
        }

        if (!empty($startDate) && !empty($endDate)) {
            $query->whereBetween('encounter_date',
                [Carbon::parse($startDate)->startOfDay(), Carbon::parse($endDate)->endOfDay()]);
        } elseif (!empty($startDate)) {
            $query->whereDate('encounter_date', '>=', Carbon::parse($startDate)->startOfDay());
        } elseif (!empty($endDate)) {
            $query->whereDate('encounter_date', '<=', Carbon::parse($endDate)->endOfDay());
        }

        $encounters = $query->orderBy('encounter_date', 'DESC')->get();

        return view('backend.pages.encounters.index', compact('encounters'));
    }

    public function show($encounter_id)
    {
        $formattedData = [];
        $sections = EncounterNoteSection::where('encounter_id', $encounter_id)
            ->whereNotNull('section_text')
            ->orderBy('id', 'ASC')
            ->get();
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
                        'Appearance:', 'Skin:', 'Head:', 'Eyes:', 'Ears:', 'Nose:', ' Throat:', 'Lungs:',
                        'Neck:', 'Chest:', 'Heart', 'Abdomen:', 'Genitourinary:', 'Musculoskeletal:',
                        'Neurological:', 'Psychiatric:'
                    ],
                    [
                        '<b>Appearance:</b>', '<b>Skin:</b>', '<b>Head:</b>', '<b>Neck:</b>', '<b>Eyes:</b>',
                        '<b>Ears:</b>',
                        '<b>Nose:</b>',
                        '<b> Throat:</b>', '<b>Lungs:</b>', '<b>Neck:</b>', '<b>Chest:</b>', '<b>Heart:</b>',
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
        return view('backend.pages.encounters.details', compact('formattedData'));
    }

    public function get_pdf($encounter_id)
    {
        set_time_limit(0);
        $encounter = PatientEncounter::findOrFail($encounter_id);

        if ($encounter) {
            $check_speciality = ListOption::where('id', $encounter->specialty)->first();

            if ($check_speciality) {
                $patient = Patient::findOrFail($encounter->patient_id);
                $user = User::with('details')->where('id', $encounter->provider_id)->first();
                $encounter_notes = EncounterNoteSection::where('encounter_id', $encounter->id)
                    ->where('patient_id', $encounter->patient_id)
                    ->whereNotNull('section_text')
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
                    $pdf->setPaper('L', 'landscape');
                    return $pdf->stream('general_encounter_pdf.pdf');
                }
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

    public function exportEncounter(Request $request)
    {
        $current_date = Carbon::now()->format('Y-m-d');
        return Excel::download(new EncounterExport(), 'export_encounter_' . $current_date . '.xlsx');
    }


}
