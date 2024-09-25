<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReviewOfSystemDetailRequest;
use App\Http\Requests\UpdateReviewOfSystemDetailRequest;
use App\Models\EncounterNoteSection;
use App\Models\ReviewOfSystemDetail;

class ReviewOfSystemDetailController extends Controller
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
    public function store(StoreReviewOfSystemDetailRequest $request)
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
            return response()->json([
                'code' => 'error',
                'message' => 'No data found'
            ], 404);
        }

        return $this->parseSectionText($data->section_text);
    }

    public function parseSectionText($sectionText)
    {
        // Replace <br></br> tags with newlines
        $cleanText = str_replace(['<br></br>', '<br>', '<br />'], "\n", $sectionText);

        // Split the text into sections
        $sections = explode("\n", trim($cleanText));

        $formattedSections = [];

        foreach ($sections as $section) {
            // Split each section into title and text
            $parts = explode(':', $section, 2);

            if (count($parts) == 2) {
                $title = trim($parts[0]);
                $text = trim($parts[1]);

                // Replace escaped slashes with single slashes
                $title = str_replace('\/', '/', $title);

                // Convert title to slug format
                $slug = strtolower(str_replace(['/', ' '], '-', $title));

                $formattedSections[] = [
                    'title' => $title,
                    'slug' => $title,
                    'text' => $text
                ];
            }
        }

        // Return JSON with unescaped slashes
        return response()->json([
            'code' => 'success',
            'data' => $formattedSections
        ], 200, [], JSON_UNESCAPED_SLASHES);
    }




    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ReviewOfSystemDetail $reviewOfSystemDetail)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    // Assuming this is inside a controller method and $reviewOfSystemDetail is your model instance


    public function update(UpdateReviewOfSystemDetailRequest $request)
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
    public function destroy(ReviewOfSystemDetail $reviewOfSystemDetail)
    {
        //
    }
}
