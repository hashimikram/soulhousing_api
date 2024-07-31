<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController as BaseController;
use App\Models\EncounterNoteSection;
use App\Models\Problem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProblemController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index($patient_id)
    {

        $problem = Problem::where('add_page', 'problem_page')->with([
            'type:id,list_id,title', 'chronicity:id,list_id,title', 'severity:id,list_id,title',
            'status:id,list_id,title'
        ])
            ->where('patient_id', $patient_id)
            ->orderBy('created_at', 'DESC')
            ->get();
        $base = new BaseController();
        if (count($problem) > 0) {
            return $base->sendResponse($problem, 'Problems Data');
        } else {
            $contact = null;
            return $base->sendError('No Record Found');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function search(Request $request)
    {
        if (!auth()->check()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        $searchTerm = $request->search_text;
        $patient_id = $request->patient_id;
        $problem = Problem::with('type:id,list_id,title', 'chronicity:id,list_id,title', 'severity:id,list_id,title',
            'status:id,list_id,title')
            ->where('patient_id', $patient_id)
            ->where(function ($query) use ($searchTerm) {
                $query->where('diagnosis', 'like', '%'.$searchTerm.'%')
                    ->orWhere('name', 'like', '%'.$searchTerm.'%')
                    ->orWhereHas('type', function ($subQuery) use ($searchTerm) {
                        $subQuery->where('title', 'like', '%'.$searchTerm.'%');
                    })
                    ->orWhereHas('chronicity', function ($subQuery) use ($searchTerm) {
                        $subQuery->where('title', 'like', '%'.$searchTerm.'%');
                    })
                    ->orWhereHas('severity', function ($subQuery) use ($searchTerm) {
                        $subQuery->where('title', 'like', '%'.$searchTerm.'%');
                    })
                    ->orWhereHas('status', function ($subQuery) use ($searchTerm) {
                        $subQuery->where('title', 'like', '%'.$searchTerm.'%');
                    });
            })
            ->get();
        return apiSuccess($problem);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (!auth()->check()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        $validatedData = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'diagnosis' => 'required',
            'name' => 'required',
            'type_id' => 'nullable|exists:list_options,id',
            'chronicity_id' => 'nullable|exists:list_options,id',
            'severity_id' => 'nullable|exists:list_options,id',
            'status_id' => 'nullable|exists:list_options,id',
            'onset' => 'nullable|date',
            'comments' => 'nullable',
        ]);
        $base = new BaseController();
        try {
            DB::beginTransaction();
            $problem = new Problem();
            $problem->add_page = "problem_page";
            $problem->provider_id = auth()->user()->id;
            $problem->patient_id = $validatedData['patient_id'];
            $problem->diagnosis = $validatedData['diagnosis'];
            $problem->name = $validatedData['name'];
            $problem->type_id = $validatedData['type_id'];
            $problem->chronicity_id = $validatedData['chronicity_id'];
            $problem->severity_id = $validatedData['severity_id'];
            $problem->status_id = $validatedData['status_id'];
            $problem->comments = $validatedData['comments'];
            $problem->onset = $validatedData['onset'];
            $problem->save();
            DB::commit();
            return $base->sendResponse($problem, 'Problem created successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return $base->sendError($e->getMessage());
        }
    }

    public function store_note_section(Request $request)
    {
        if (!auth()->check()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        $validatedData = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'diagnosis' => 'nullable',
            'name' => 'required',
        ]);
        $base = new BaseController();
        try {
            DB::beginTransaction();
            $problem = new Problem();
            $problem->add_page = "encounter_note";
            $problem->provider_id = auth()->user()->id;
            $problem->patient_id = $validatedData['patient_id'];
            $problem->diagnosis = $validatedData['diagnosis'];
            $problem->name = $validatedData['name'];
            $problem->save();
            DB::commit();
            $problem->assessment_section_id = $request->assessment_section_id;
            $existingSection = EncounterNoteSection::where('id', $request->assessment_section_id)->first();
            if ($existingSection) {
                $existingSectionText = json_decode($existingSection->section_text, true);

                $newData = [
                    'Code' => $request->diagnosis,
                    'Description' => $request->name,
                    'assessment_input' => "",
                    'value_id' => rand(123456, 999999),
                ];

                $existingSectionText[] = $newData;

                $existingSection->assessment_note = json_encode($existingSectionText);
                $existingSection->save();
                Log::info('Section Text Updated');
            }

            return $base->sendResponse($problem, 'Problem created successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return $base->sendError($e->getMessage());
        }
    }

    public function store_cpt_section(Request $request)
    {
        if (!auth()->check()) {
            return response()->json(['message' => 'Unauthorized access. Please log in to continue.'], 401);
        }

        $validatedData = $request->validate([
            'procedure_id' => 'required|exists:encounter_note_sections,id',
            'code' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
        ]);
        $base = new BaseController();

        DB::beginTransaction();
        try {
            // Retrieve the existing section
            $existingSection = EncounterNoteSection::find($validatedData['procedure_id']);
            if ($existingSection) {
                $code = e($request->code);
                $description = e($request->description);
                $newText = "Code: {$code}\nDescription: {$description}\n";
                $existingSection->section_text .= $newText;
                $existingSection->save();

                DB::commit();

                Log::info('Section text successfully updated for procedure ID: '.$validatedData['procedure_id']);
                return $base->sendResponse($newText, 'Section text successfully updated.');
            } else {
                return response()->json(['message' => 'Procedure not found.'], 404);
            }

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to update section text: '.$e->getMessage());
            return $base->sendError('An error occurred while updating the section text. Please try again later.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Problem $problem)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Problem $problem)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {

        $validatedData = $request->validate([
            'problem_id' => 'required|exists:problems,id',
            'diagnosis' => 'nullable',
            'name' => 'required',
            'type_id' => 'nullable|exists:list_options,id',
            'chronicity_id' => 'nullable|exists:list_options,id',
            'severity_id' => 'nullable|exists:list_options,id',
            'status_id' => 'nullable|exists:list_options,id',
            'onset' => 'nullable|date',
            'comments' => 'nullable',
        ]);
        $base = new BaseController();

        try {
            $problem = Problem::FindOrFail($request->problem_id);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['error' => 'Problem not found'], 404);
        }

        try {
            DB::beginTransaction();
            $problem->diagnosis = $validatedData['diagnosis'];
            $problem->name = $validatedData['name'];
            $problem->type_id = $validatedData['type_id'];
            $problem->chronicity_id = $validatedData['chronicity_id'];
            $problem->severity_id = $validatedData['severity_id'];
            $problem->status_id = $validatedData['status_id'];
            $problem->comments = $validatedData['comments'];
            $problem->onset = $validatedData['onset'];
            $problem->save();
            DB::commit();
            return $base->sendResponse($problem, 'Problem updated successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            $problem = [];
            return $base->sendError($problem, $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Problem $problem)
    {
        $base = new BaseController();
        $problem->delete();
        return $base->sendResponse([], 'Problem deleted successfully');
    }
}
