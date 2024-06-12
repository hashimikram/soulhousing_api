<?php

namespace App\Http\Controllers;

use App\Models\EncounterTemplate;
use Illuminate\Http\Request;

class EncounterTemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $encounterTemplate = EncounterTemplate::where('provider_id', auth()->user()->id)->first();

        // Decode the JSON data stored in the encounter_template column
        $encounterTemplate->encounter_template = json_decode($encounterTemplate->encounter_template, true);

        return response()->json([
            'data' => $encounterTemplate
        ], 200);
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
        $data = $request->validate([
            'template_name' => 'required|string',
            'template_sections' => 'required|array',
        ]);
        $templateName = $data['template_name'];
        $templateSections = $data['template_sections'];

        $encounterTemplate = new EncounterTemplate();
        $encounterTemplate->provider_id = auth()->user()->id; // Assuming provider ID is the currently authenticated user's ID
        $encounterTemplate->template_name = $templateName;
        $encounterTemplate->encounter_template = json_encode($templateSections);
        $encounterTemplate->save();
        return response()->json([
            'success' => true,
            'message' => 'Data Added'
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(EncounterTemplate $encounterTemplate)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EncounterTemplate $encounterTemplate)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, EncounterTemplate $encounterTemplate)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EncounterTemplate $encounterTemplate)
    {
        //
    }
}
