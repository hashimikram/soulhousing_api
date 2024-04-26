<?php

namespace App\Http\Controllers\Api;

use App\Models\Problem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Api\BaseController as BaseController;

class ProblemController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index($patient_id)
    {
        $problem = Problem::where('patient_id', $patient_id)->orderBy('created_at', 'DESC')->get();
        $base = new BaseController();
        if (count($problem) > 0) {
            return $base->sendResponse($problem, 'Problems Data');
        } else {
            $contact = NULL;
            return $base->sendError('No Record Found');
        }
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
        if (!auth()->check()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        $validatedData = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'diagnosis' => 'required',
            'name' => 'required',
            'type_id' => 'required|exists:list_options,id',
            'chronicity_id' => 'exists:list_options,id',
            'severity_id' => 'exists:list_options,id',
            'status_id' => 'exists:list_options,id',
            'onset' => 'nullable|date',
            'comments' => 'required|nullable',
            'snowed' => 'nullable',
        ]);
        $base = new BaseController();
        try {
            DB::beginTransaction();
            $problem = new Problem();
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
            $problem->snowed = $validatedData['snowed'];
            $problem->save();
            DB::commit();
            return $base->sendResponse($problem, 'Problem created successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return $base->sendError($problem, $e->getMessage());
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
        if (!auth()->check()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }



        $validatedData = $request->validate([
            'problem_id' => 'required|exists:problems,id',
            'diagnosis' => 'required',
            'name' => 'required',
            'type_id' => 'required|exists:list_options,id',
            'chronicity_id' => 'exists:list_options,id',
            'severity_id' => 'exists:list_options,id',
            'status_id' => 'exists:list_options,id',
            'onset' => 'nullable|date',
            'comments' => 'required|nullable',
            'snowed' => 'nullable',
        ]);
        $base = new BaseController();

        try {
            $problem = Problem::FindOrFail($request->problem_id);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['error' => 'Problem not found'], 404);
        }

        try {
            DB::beginTransaction();
            if ($problem->provider_id !== auth()->user()->id) {
                return response()->json(['error' => 'Unauthorized'], 403);
            }
            $problem->diagnosis = $validatedData['diagnosis'];
            $problem->name = $validatedData['name'];
            $problem->type_id = $validatedData['type_id'];
            $problem->chronicity_id = $validatedData['chronicity_id'];
            $problem->severity_id = $validatedData['severity_id'];
            $problem->status_id = $validatedData['status_id'];
            $problem->comments = $validatedData['comments'];
            $problem->onset = $validatedData['onset'];
            $problem->snowed = $validatedData['snowed'];
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
