<?php

namespace App\Http\Controllers\Api;

use App\Models\Vital;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Api\BaseController as BaseController;


class VitalController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index($patient_id)
    {
        if (!auth()->check()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        $vitals = Vital::where('patient_id', $patient_id)->get();
        return response()->json([
            'success' => true,
            'data' => $vitals,
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
        $validatedData = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'vital_type' => 'required|string',
            'blood_sugar' => 'required|string',
            'time' => 'required|date_format:H:i:s',
            'pulse_result' => 'required|string',
            'pulse_rhythm' => 'required|string',
            'pulse_time' => 'required|date_format:H:i:s',
            'body_temperature_result_f' => 'required|string',
            'body_temperature_result_c' => 'required|string',
            'body_temperature_method' => 'required|string',
            'body_temperature_time' => 'required|date_format:H:i:s',
            'respiration_result' => 'required|string',
            'respiration_pattern' => 'required|string',
            'respiration_time' => 'required|date_format:H:i:s',
            'oxygenation_saturation' => 'required|string',
            'oxygenation_method' => 'required|string',
            'oxygenation_device' => 'required|string',
            'oxygenation_oxygen_source' => 'required|string',
            'oxygenation_time' => 'required|date_format:H:i:s',
            'oxygenation_inhaled_02_concentration' => 'required|string',
            'oxygenation_oxygen_flow' => 'required|string',
            'oxygenation_time_2' => 'required|date_format:H:i:s',
            'oxygenation_peak_flow' => 'required|string',
            'oxygenation_time_3' => 'required|date_format:H:i:s',
            'office_tests' => 'required|string',
            'office_tests_date' => 'required|date',
            'office_tests_pain_scale' => 'required|integer|min:0|max:10',
            'office_tests_date_2' => 'required|date',
            'office_tests_comments' => 'nullable|string',
        ]);
        if (!auth()->check()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        try {
            DB::beginTransaction();
            $validatedData['provider_id'] = auth()->user()->id;
            $vital = new Vital($validatedData);
            $vital->save();
            DB::commit();
            return response()->json(['message' => 'Vital data stored successfully'], 201);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 500);
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
        $vital = Vital::where('id', $id)->first();
        if (isset($vital)) {
            if ($vital->provider_id != auth()->user()->id) {
                return response()->json(['message' => 'Unauthorized'], 401);
            }
        }
        return response()->json([
            'success' => true,
            'data' => $vital,
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Vital $vital)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'id' => 'required|exists:vitals,id',
            'vital_type' => 'required|string',
            'blood_sugar' => 'required|string',
            'time' => 'required|date_format:H:i:s',
            'pulse_result' => 'required|string',
            'pulse_rhythm' => 'required|string',
            'pulse_time' => 'required|date_format:H:i:s',
            'body_temperature_result_f' => 'required|string',
            'body_temperature_result_c' => 'required|string',
            'body_temperature_method' => 'required|string',
            'body_temperature_time' => 'required|date_format:H:i:s',
            'respiration_result' => 'required|string',
            'respiration_pattern' => 'required|string',
            'respiration_time' => 'required|date_format:H:i:s',
            'oxygenation_saturation' => 'required|string',
            'oxygenation_method' => 'required|string',
            'oxygenation_device' => 'required|string',
            'oxygenation_oxygen_source' => 'required|string',
            'oxygenation_time' => 'required|date_format:H:i:s',
            'oxygenation_inhaled_02_concentration' => 'required|string',
            'oxygenation_oxygen_flow' => 'required|string',
            'oxygenation_time_2' => 'required|date_format:H:i:s',
            'oxygenation_peak_flow' => 'required|string',
            'oxygenation_time_3' => 'required|date_format:H:i:s',
            'office_tests' => 'required|string',
            'office_tests_date' => 'required|date',
            'office_tests_pain_scale' => 'required|integer|min:0|max:10',
            'office_tests_date_2' => 'required|date',
            'office_tests_comments' => 'nullable|string',
        ]);
        if (!auth()->check()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        // Check if the user is authenticated
        if (!auth()->check()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        try {
            // Find the existing Vital record by ID
            $vital = Vital::findOrFail($request->id);

            // Update the attributes of the existing Vital record with the validated data
            $vital->fill($validatedData);

            // Save the updated Vital record
            $vital->save();

            return response()->json(['message' => 'Vital data updated successfully'], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['error' => 'Vital not found'], 404);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        if (!is_numeric($id) || $id <= 0) {
            return response()->json(['error' => 'Invalid Vital ID'], 400);
        }

        try {
            $vital = Vital::findOrFail($id);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['error' => 'Vital not found'], 404);
        }

        if ($vital->provider_id !== auth()->user()->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // 4. Attempt to delete the note
        try {
            $vital->delete();
        } catch (\Exception $e) {
            return response()->json(['error' =>  $e->getMessage()], 500);
        }

        // 5. Return success response
        return response()->json(['message' => 'Vital deleted successfully'], 200);
    }
}
