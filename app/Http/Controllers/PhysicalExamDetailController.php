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

        // Remove <br> and </br> from the text
        $sectionsText = str_replace(['<br>', '</br>'], '', $data->section_text);

        // Split the text into sections using regex
        $sectionsArray = preg_split(
            '/(?=[A-Z][a-z]+(?:\/[A-Z][a-z]+)?(?: & [A-Z][a-z]+)?:\s)/s',
            $sectionsText,
            -1,
            PREG_SPLIT_NO_EMPTY
        );

        $formattedSections = [];

        foreach ($sectionsArray as $section) {
            // Extract the title and content using regex
            if (preg_match('/^([A-Z][a-z]+(?:\/[A-Z][a-z]+)?(?: & [A-Z][a-z]+)?):\s*(.*)/s', $section, $matches)) {
                $sectionTitle = $matches[1];

                // Special case for "Mouth & Throat"
                if (strcasecmp($sectionTitle, 'Mouth & Throat') == 0) {
                    $sectionTitle = 'Mouth and throat';
                }

                // Convert the section title to camelCase
                $sectionTitle = lcfirst(str_replace(
                    ' ',
                    '',
                    ucwords(str_replace(['&', '_'], [' and ', ' '], strtolower($sectionTitle)))
                ));

                // Clean up section content
                $sectionContent = trim(str_replace(['<br>', '</br>'], '', $matches[2]));

                // Add the formatted section title and content to the result
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

        // Fetch the data from the database
        $data = EncounterNoteSection::where('id', $request->id)
            ->first();

        if (!$data) {
            // Return error response if no data found
            return response()->json([
                'code' => 'error',
                'message' => 'No data found'
            ], 404);
        }

        // Get the payload data
        $payload = $request->all();

        // Initialize an empty string to hold the formatted section text
        $sectionText = '';

        // Iterate over each section and format it
        foreach ($payload as $key => $value) {

            if ($key !== 'id') {

                $sectionText .= ucfirst($key) . ': ' . $value . '<br><br>';
            }
        }

        // Update the section text
        $data->section_text = $sectionText;

        // Save the changes
        $data->save();

        // Return success response
        return response()->json([
            'code' => 'success',
            'message' => 'Data updated successfully'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PhysicalExamDetail $physicalExamDetail)
    {
        //
    }
}
