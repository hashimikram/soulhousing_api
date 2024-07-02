<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController as BaseController;
use App\Models\Vital;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        $vitals = Vital::orderBy('id', 'DESC')->where('patient_id', $patient_id)->get();
        foreach ($vitals as $data) {
            $data->create_date = date('d-m-Y h:i A', strtotime($data->created_at));
        }
        return response()->json([
            'success' => true,
            'data' => $vitals,
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function search(Request $request)
    {
        $validatedData = $request->validate([
            'from_date' => 'required|date|before_or_equal:to_date',
            'to_date' => 'required|date|after_or_equal:from_date',
            'patient_id' => 'required',
        ], [
            // Custom error messages
            'from_date.before_or_equal' => 'The From Date must be before or equal to the To Date.',
            'to_date.after_or_equal' => 'The To Date must be after or equal to the From Date.',
        ]);
        $fromDate = $validatedData['from_date'];
        $toDate = $validatedData['to_date'];
        $patientId = $validatedData['patient_id'];
        $vitals = Vital::orderBy('id', 'DESC')->whereBetween('date', [$fromDate, $toDate])->where('patient_id',
            $patientId)->get();
        return response()->json([
            'success' => true,
            'data' => $vitals,
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'date' => 'required|date',
            'weight_lbs' => 'nullable|string',
            'weight_oz' => 'nullable|string',
            'weight_kg' => 'nullable|string',
            'height_ft' => 'nullable|string',
            'height_in' => 'nullable|string',
            'height_cm' => 'nullable|string',
            'bmi_kg' => 'nullable|string',
            'bmi_in' => 'nullable|string',
            'bsa_cm2' => 'nullable|string',
            'waist_cm' => 'nullable|string',
            'systolic' => 'nullable|string',
            'diastolic' => 'nullable|string',
            'position' => 'nullable|string',
            'cuff_size' => 'nullable|string',
            'cuff_location' => 'nullable|string',
            'cuff_time' => 'nullable|string',
            'fasting' => 'nullable|string',
            'postprandial' => 'nullable|string',
            'fasting_blood_sugar' => 'nullable|string',
            'blood_sugar_time' => 'nullable|string',
            'pulse_result' => 'nullable|string',
            'pulse_rhythm' => 'nullable|string',
            'pulse_time' => 'nullable|string',
            'body_temp_result_f' => 'nullable|string',
            'body_temp_result_c' => 'nullable|string',
            'body_temp_method' => 'nullable|string',
            'body_temp_time' => 'nullable|string',
            'respiration_result' => 'nullable|string',
            'respiration_pattern' => 'nullable|string',
            'respiration_time' => 'nullable|string',
            'saturation' => 'nullable|string',
            'oxygenation_method' => 'nullable|string',
            'device' => 'nullable|string',
            'oxygen_source_1' => 'nullable|string',
            'oxygenation_time_1' => 'nullable|string',
            'inhaled_o2_concentration' => 'nullable|string',
            'oxygen_flow' => 'nullable|string',
            'oxygen_source_2' => 'nullable|string',
            'oxygenation_time_2' => 'nullable|string',
            'peak_flow' => 'nullable|string',
            'oxygenation_time_3' => 'nullable|string',
            'office_test_blood_group' => 'nullable|string',
            'blood_group_date' => 'nullable|date',
            'office_test_pain_scale' => 'nullable|string',
            'pain_scale_date' => 'nullable|date',
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
            'date' => 'required|date',
            'weight_lbs' => 'nullable|string',
            'weight_oz' => 'nullable|string',
            'weight_kg' => 'nullable|string',
            'height_ft' => 'nullable|string',
            'height_in' => 'nullable|string',
            'height_cm' => 'nullable|string',
            'bmi_kg' => 'nullable|string',
            'bmi_in' => 'nullable|string',
            'bsa_cm2' => 'nullable|string',
            'waist_cm' => 'nullable|string',
            'systolic' => 'nullable|string',
            'diastolic' => 'nullable|string',
            'position' => 'nullable|string',
            'cuff_size' => 'nullable|string',
            'cuff_location' => 'nullable|string',
            'cuff_time' => 'nullable|string',
            'fasting' => 'nullable|string',
            'postprandial' => 'nullable|string',
            'fasting_blood_sugar' => 'nullable|string',
            'blood_sugar_time' => 'nullable|string',
            'pulse_result' => 'nullable|string',
            'pulse_rhythm' => 'nullable|string',
            'pulse_time' => 'nullable|string',
            'body_temp_result_f' => 'nullable|string',
            'body_temp_result_c' => 'nullable|string',
            'body_temp_method' => 'nullable|string',
            'body_temp_time' => 'nullable|string',
            'respiration_result' => 'nullable|string',
            'respiration_pattern' => 'nullable|string',
            'respiration_time' => 'nullable|string',
            'saturation' => 'nullable|string',
            'oxygenation_method' => 'nullable|string',
            'device' => 'nullable|string',
            'oxygen_source_1' => 'nullable|string',
            'oxygenation_time_1' => 'nullable|string',
            'inhaled_o2_concentration' => 'nullable|string',
            'oxygen_flow' => 'nullable|string',
            'oxygen_source_2' => 'nullable|string',
            'oxygenation_time_2' => 'nullable|string',
            'peak_flow' => 'nullable|string',
            'oxygenation_time_3' => 'nullable|string',
            'office_test_oxygen_source_1' => 'nullable|string',
            'office_test_date_1' => 'nullable|date',
            'office_test_oxygen_source_2' => 'nullable|string',
            'office_test_date_2' => 'nullable|date',
        ]);

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
            return response()->json(['error' => $e->getMessage()], 500);
        }

        // 5. Return success response
        return response()->json(['message' => 'Vital deleted successfully'], 200);
    }
}
