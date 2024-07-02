<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController as BaseController;
use App\Models\Allergy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AllergyController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index($patient_id)
    {
        if (!auth()->check()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        $allergy = Allergy::with('allergy_type:id,list_id,title', 'severity:id,list_id,title',
            'reaction:id,list_id,title')->where('patient_id', $patient_id)->get();
        return apiSuccess($allergy);
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
        $allergy = Allergy::with('allergy_type:id,list_id,title', 'severity:id,list_id,title',
            'reaction:id,list_id,title')
            ->where('patient_id', $patient_id)
            ->where(function ($query) use ($searchTerm) {
                $query->where('allergy', 'like', '%'.$searchTerm.'%')
                    ->orWhereHas('allergy_type', function ($subQuery) use ($searchTerm) {
                        $subQuery->where('title', 'like', '%'.$searchTerm.'%');
                    })
                    ->orWhereHas('severity', function ($subQuery) use ($searchTerm) {
                        $subQuery->where('title', 'like', '%'.$searchTerm.'%');
                    })
                    ->orWhereHas('reaction', function ($subQuery) use ($searchTerm) {
                        $subQuery->where('title', 'like', '%'.$searchTerm.'%');
                    });
            })
            ->get();

        return apiSuccess($allergy);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (!auth()->check()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        $validate = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'allergy_type' => 'required|exists:list_options,id',
            'allergy' => 'nullable',
            'reaction_id' => 'required|exists:list_options,id',
            'severity_id' => 'required|exists:list_options,id',
            'onset_date' => 'date|nullable',
            'comments' => 'nullable',
        ]);
        try {
            DB::beginTransaction();
            $allergy = new Allergy();
            $allergy->provider_id = auth()->user()->id;
            $allergy->patient_id = $validate['patient_id'];
            $allergy->allergy_type = $validate['allergy_type'];
            $allergy->allergy = $validate['allergy'];
            $allergy->reaction = $validate['reaction_id'];
            $allergy->severity = $validate['severity_id'];
            $allergy->onset_date = $validate['onset_date'];
            $allergy->comments = $validate['comments'];
            $allergy->save();
            DB::commit();
            return apiSuccess('Allergy Created');
        } catch (\Exception $e) {
            DB::rollBack();
            return apiError($e->getMessage(), 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        if (!auth()->check()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        $allergy = Allergy::with('allergy_type:id,list_id,title', 'severity:id,list_id,title',
            'reaction:id,list_id,title')->where('id', $id)->first();

        if ($allergy != null) {
            if (auth()->user()->id != $allergy->provider_id) {
                return response()->json(['message' => 'Unauthorized'], 401);
            }
            return apiSuccess($allergy);
        } else {
            return apiError('No Record Found', 404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Allergy $allergy)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $validate = $request->validate([
            'id' => 'required|exists:allergies,id',
            'allergy_type' => 'required|exists:list_options,id',
            'allergy' => 'nullable',
            'reaction_id' => 'required|exists:list_options,id',
            'severity_id' => 'required|exists:list_options,id',
            'onset_date' => 'date|nullable',
            'comments' => 'nullable',
        ]);

        if (!auth()->check()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        try {
            $allergy = Allergy::findOrFail($request->id);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['error' => 'Allergy not found'], 404);
        }

        if ($allergy->provider_id !== auth()->user()->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        try {
            DB::beginTransaction();
            $allergy->allergy_type = $validate['allergy_type'];
            $allergy->allergy = $validate['allergy'];
            $allergy->reaction = $validate['reaction_id'];
            $allergy->severity = $validate['severity_id'];
            $allergy->onset_date = $validate['onset_date'];
            $allergy->comments = $validate['comments'];
            $allergy->save();
            DB::commit();

            return response()->json(['message' => 'Allergy updated successfully'], 200);
        } catch (\Exception $e) {
            DB::rollback();

            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        if (!is_numeric($id) || $id <= 0) {
            return response()->json(['error' => 'Invalid note ID'], 400);
        }

        try {
            $allergy = Allergy::findOrFail($id);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['error' => 'Note not found'], 404);
        }

        if ($allergy->provider_id !== auth()->user()->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // 4. Attempt to delete the note
        try {
            $allergy->delete();
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }

        // 5. Return success response
        return response()->json(['message' => 'Allergy deleted successfully'], 200);
    }
}
