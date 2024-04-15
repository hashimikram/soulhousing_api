<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\EncounterNoteSection;
use App\Models\PatientEncounter;
use Illuminate\Http\Request;

class EncounterNoteSectionController extends BaseController
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(EncounterNoteSection $encounterNoteSection)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EncounterNoteSection $encounterNoteSection)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        try {
            $notes = PatientEncounter::find($request->id);
            $notes->section_text = $request->section_text;
            $notes->attached_entities = $request->attached_entities;
            $notes->save();
            $base = new BaseController();
            return $base->sendResponse(NULL, 'Note Updated');
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EncounterNoteSection $encounterNoteSection)
    {
        //
    }
}
