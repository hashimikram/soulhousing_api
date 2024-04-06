<?php

namespace App\Http\Controller\Api;

use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\EncounterNoteSection;
use App\Models\PatientEncounter;
use Faker\Provider\Base;
use Illuminate\Http\Request;

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
            // Validate the incoming request
            $validatedData = $request->validate([
                'patient_id' => 'required|exists:patients,id',
                'signed_at' => 'required',
                'encounter_type' => 'required',
                'encounter_template' => 'required',
                'reason' => 'required'
            ]);

            $encounter = new PatientEncounter($validatedData);
            $encounter->provider_id = auth()->user()->id;
            $encounter->signed_by = auth()->user()->id;
            $encounter->save();

            $sections = [
                ['title' => 'chief_complained', 'slug' => 'chief-complained'],
                ['title' => 'history', 'slug' => 'history'],
                ['title' => 'medical_history', 'slug' => 'medical-history'],
                ['title' => 'surgical_history', 'slug' => 'surgical-history'],
                ['title' => 'family_history', 'slug' => 'family-history'],
                ['title' => 'social_history', 'slug' => 'social-history'],
                ['title' => 'allergies', 'slug' => 'allergies'],
                ['title' => 'medications', 'slug' => 'medications'],
            ];

            foreach ($sections as $section) {
                $notes = new EncounterNoteSection();
                $notes->encounter_id = $encounter->id;
                $notes->section_title = $section['title'];
                $notes->section_slug = $section['slug'];
                $notes->section_text = $request->section_text;
                $notes->sorting_order = $request->sorting_order;
                $notes->attachedd_entities = json_decode($request->attached_entities);
                $notes->save();
            }
            $base =  new BaseController();
            return $base->sendResponse(null, 'Data Added');
        } catch (\Exception $e) {
            // Log the error or handle it appropriately
            // You can return a custom error response or rethrow the exception
            return response()->json(['error' => $e->getMessage()], 500);
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(PatientEncounter $patientEncounter)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PatientEncounter $patientEncounter)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PatientEncounter $patientEncounter)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PatientEncounter $patientEncounter)
    {
        //
    }
}
