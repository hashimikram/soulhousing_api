<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePhysicalExamDetailRequest;
use App\Http\Requests\UpdatePhysicalExamDetailRequest;
use App\Models\EncounterNoteSection;
use App\Models\PhysicalExamDetail;

class PhysicalExamDetailController extends Controller
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
    public function store(StorePhysicalExamDetailRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($section_id, $patient_id)
    {
        // Fetch the data from the database
        $data = EncounterNoteSection::where('patient_id', $patient_id)
            ->where('id', $section_id)
            ->first();

        if (!$data) {
            // Return error response if no data found
            return response()->json([
                'code' => 'error',
                'message' => 'No data found'
            ], 404);
        }

        $sectionsText = str_replace(['<br>', '</br>'], '', $data->section_text);
        // Split the sections using regex, ensuring to match sections correctly
        $sectionsArray = preg_split('/(?=[A-Z][a-z]+(?:\/[A-Z][a-z]+)?:(?=\s))/s', $sectionsText, -1,
            PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY);
        $formattedSections = [];

        foreach ($sectionsArray as $section) {
            if (preg_match('/^([A-Z][a-z]+(?:\/[A-Z][a-z]+)?):\s*(.*)/s', $section, $matches)) {
                // Convert the section title to camelCase
                $sectionTitle = lcfirst(str_replace(' ', '', ucwords(str_replace('_', ' ', strtolower($matches[1])))));
                $sectionContent = trim(str_replace(['<br>', '</br>'], '', $matches[2]));
                $formattedSections[$sectionTitle] = $sectionContent;
            }
        }

        return response()->json([
            'code' => 'success',
            'data' => $formattedSections
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PhysicalExamDetail $physicalExamDetail)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePhysicalExamDetailRequest $request)
    {

        $physicalExamDetail = PhysicalExamDetail::find($request->id);
        if (!$physicalExamDetail) {
            return response()->json(['error' => 'Physical exam detail not found.'], 404);
        }
        $physicalExamDetail->general_appearance = $request->input('general_appearance', 'constitutional');
        $physicalExamDetail->skin = $request->input('skin');
        $physicalExamDetail->head = $request->input('head');
        $physicalExamDetail->eyes = $request->input('eyes');
        $physicalExamDetail->ears = $request->input('ears');
        $physicalExamDetail->nose = $request->input('nose');
        $physicalExamDetail->mouth_throat = $request->input('mouth_throat');
        $physicalExamDetail->neck = $request->input('neck');
        $physicalExamDetail->chest_lungs = $request->input('chest_lungs');
        $physicalExamDetail->cardiovascular = $request->input('cardiovascular');
        $physicalExamDetail->abdomen = $request->input('abdomen');
        $physicalExamDetail->genitourinary = $request->input('genitourinary');
        $physicalExamDetail->musculoskeletal = $request->input('musculoskeletal');
        $physicalExamDetail->neurological = $request->input('neurological');
        $physicalExamDetail->psychiatric = $request->input('psychiatric');
        $physicalExamDetail->endocrine = $request->input('endocrine');
        $physicalExamDetail->hematologic_lymphatic = $request->input('hematologic_lymphatic');
        $physicalExamDetail->allergic_immunologic = $request->input('allergic_immunologic');
        $physicalExamDetail->save();

        return response()->json(['message' => 'Physical exam detail updated successfully.']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PhysicalExamDetail $physicalExamDetail)
    {
        //
    }
}
