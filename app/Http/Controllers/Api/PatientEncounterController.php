<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Str;
use App\Models\PhysicalExam;
use Illuminate\Http\Request;
use App\Models\ReviewOfSystem;
use App\Models\PatientEncounter;
use Illuminate\Support\Facades\Log;
use App\Models\EncounterNoteSection;
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
        try {
            $encounter = new PatientEncounter();
            $encounter->patient_id = $request->patient_id;
            $encounter->provider_id = auth()->user()->id;
            $encounter->signed_at = $request->signed_at;
            $encounter->signed_by =  auth()->user()->id;
            $encounter->encounter_type = $request->encounter_type;
            $encounter->encounter_template = $request->encounter_template;
            $encounter->reason = $request->reason;
            $encounter->save();

            $data = $request->json()->all();

            $includeFields = ['section_text', 'review_of_system', 'physical_exam'];

            foreach ($includeFields as $sectionTitle) {
                $sectionData = $data[$sectionTitle] ?? null;

                if ($sectionData === null) {
                    continue;
                }

                if (is_array($sectionData)) {
                    if ($sectionTitle === 'review_of_system' || $sectionTitle === 'physical_exam') {
                        EncounterNoteSection::create([
                            'provider_id' => auth()->user()->id,
                            'patient_id' => $request->patient_id,
                            'encounter_id' => $encounter->id,
                            'section_title' => ucwords(str_replace('_', ' ', $sectionTitle)),
                            'section_slug' => $sectionTitle,
                            'section_text' => json_encode($sectionData),
                            'sorting_order' => 1,
                        ]);
                    } else {
                        foreach ($sectionData as $subsectionTitle => $subsectionData) {
                            $sectionSlug = $sectionTitle;
                            $sortingOrder = array_search($subsectionTitle, array_keys($data['sorting_order'])) + 1;

                            EncounterNoteSection::create([
                                'provider_id' => auth()->user()->id,
                                'patient_id' => $request->patient_id,
                                'encounter_id' => $encounter->id,
                                'section_title' => ucwords(str_replace('_', ' ', $subsectionTitle)),
                                'section_slug' => $subsectionTitle,
                                'section_text' => is_array($subsectionData) ? json_encode($subsectionData) : $subsectionData,
                                'sorting_order' => $sortingOrder,
                            ]);
                        }
                    }
                } else {
                    return response()->json(['error' => "Unexpected data structure for section {$sectionTitle}"], 400);
                }
            }


            return response()->json(['message' => 'Data stored successfully'], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($patient_id)
    {
        $data = PatientEncounter::where('patient_id', $patient_id)->get();
        $base = new BaseController();
        return $base->sendResponse($data, 'Patient Encounter Fetched');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function encounter_notes($encounter_id)
    {
        // Get encounter note sections
        $sections = EncounterNoteSection::where('encounter_id', $encounter_id)->get();
        if ($sections->isEmpty()) {
            return response()->json(['success' => false, 'message' => 'No encounter note sections found for the given encounter ID'], 404);
        }
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
}
