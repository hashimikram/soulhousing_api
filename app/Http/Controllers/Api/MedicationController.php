<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController as BaseController;
use App\Http\Requests\MedicationRequest;
use App\Models\medication;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MedicationController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index($id)
    {
        $active_medications = medication::with(['patients', 'staff'])->where('status', 'active')->where('patient_id',
            $id)->get();
        $inactive_medications = medication::with('patients')->where('status', 'inactive')->where('patient_id',
            $id)->get();

        foreach ($active_medications as $result) {
        

            if (isset($result->end_date)) {
                $enddate = Carbon::parse($result->end_date);
                if (Carbon::now()->isAfter($enddate)) {
                    $result->status = 'inactive';
                }
            } else {
                $result->end_date = '';
            }

            $formatted_data = $result->title;

            if (!empty($result->dose) && !empty($result->dosage_unit)) {
                $formatted_data .= ' - '.$result->dose.' '.$result->dosage_unit;
            }

            if (!empty($result->quantity)) {
                $formatted_data .= ', '.$result->quantity;
            }

            if (!empty($result->frequency)) {
                $formatted_data .= ' ('.$result->frequency.')';
            }

            $result->formatted_data = $formatted_data;


        }


        foreach ($inactive_medications as $result_inactive) {
            if (isset($result_inactive->end_date)) {
                $result_inactive->end_date = $result_inactive->end_date;
            } else {
                $result_inactive->end_date = '';
            }

            $formatted_data = $result_inactive->title;

            if (!empty($result_inactive->dose) && !empty($result_inactive->dosage_unit)) {
                $formatted_data .= ' - '.$result_inactive->dose.' '.$result_inactive->dosage_unit;
            }

            if (!empty($result_inactive->quantity)) {
                $formatted_data .= ', '.$result_inactive->quantity;
            }

            if (!empty($result_inactive->frequency)) {
                $formatted_data .= ' ('.$result_inactive->frequency.')';
            }

            $result_inactive->formatted_data = $formatted_data;
        }


        return response()->json([
            'active_medications' => $active_medications,
            'inactive_medications' => $inactive_medications
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
    public function store(MedicationRequest $request)
    {
        $base = new BaseController();
        try {
            $medication = new medication();
            $medication->favourite_medication = $request->favourite_medication;
            $medication->provider_id = auth()->user()->id;
            $medication->patient_id = $request->patient_id;
            $medication->title = $request->title;
            $medication->dose = $request->dose;
            $medication->strength = $request->strength;
            $medication->user_free_text = $request->user_free_text;
            $medication->prescribe_date = $request->prescribe_date;
            $medication->action = $request->action;
            $medication->quantity = $request->quantity;
            $medication->unit = $request->unit;
            $medication->begin_date = $request->begin_date;
            $medication->end_date = $request->end_date;
            $medication->referred_by = $request->referred_by;
            $medication->medication_dosage_instruction = $request->medication_dosage_instruction;
            $medication->dosage_unit = $request->dosage_unit;
            $medication->route = $request->route;
            $medication->frequency = $request->frequency;
            $medication->days_supply = $request->days_supply;
            $medication->refills = $request->refills;
            $medication->dispense = $request->dispense;
            $medication->dispense_unit = $request->dispense_unit;
            $medication->primary_diagnosis = $request->primary_diagnosis;
            $medication->secondary_diagnosis = $request->secondary_diagnosis;
            $medication->substitutions = $request->substitutions;
            $medication->one_time = $request->one_time;
            $medication->prn = $request->prn;
            $medication->administered = $request->administered;
            $medication->prn_options = $request->prn_options;
            $medication->patient_directions = $request->patient_directions;
            $medication->additional_sig = $request->additional_sig;
            $medication->quantity_left = $request->quantity_left;
            if (isset($request->end_date)) {
                $enddate = Carbon::parse($request->end_date);
                if (Carbon::now()->isAfter($enddate)) {
                    $medication->status = 'inactive';
                }
            }

            $medication->save();
            return $base->sendResponse(null, 'Medication Added');
        } catch (\Exception $e) {
            return $base->$e->getMessage();
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(medication $medication)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(medication $medication)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'title' => 'required',
            'strength' => 'nullable',
            'begin_date' => 'required|date',
            'end_date' => 'nullable|date',
            'dosage_unit' => 'required',
            'dose' => 'required',
        ]);
        $base = new BaseController();
        try {
            $medication = medication::find($request->id);
            if ($medication != null) {
                $medication->favourite_medication = $request->favourite_medication;
                $medication->title = $request->title;
                $medication->strength = $request->strength;
                $medication->user_free_text = $request->user_free_text;
                $medication->prescribe_date = $request->prescribe_date;
                $medication->dose = $request->dose;
                $medication->action = $request->action;
                $medication->quantity = $request->quantity;
                $medication->unit = $request->unit;
                $medication->begin_date = $request->begin_date;
                $medication->end_date = $request->end_date;
                $medication->referred_by = $request->referred_by;
                $medication->medication_dosage_instruction = $request->medication_dosage_instruction;
                $medication->dosage_unit = $request->dosage_unit;
                $medication->route = $request->route;
                $medication->frequency = $request->frequency;
                $medication->days_supply = $request->days_supply;
                $medication->refills = $request->refills;
                $medication->dispense = $request->dispense;
                $medication->dispense_unit = $request->dispense_unit;
                $medication->primary_diagnosis = $request->primary_diagnosis;
                $medication->secondary_diagnosis = $request->secondary_diagnosis;
                $medication->substitutions = $request->substitutions;
                $medication->one_time = $request->one_time;
                $medication->prn = $request->prn;
                $medication->administered = $request->administered;
                $medication->prn_options = $request->prn_options;
                $medication->patient_directions = $request->patient_directions;
                $medication->additional_sig = $request->additional_sig;
                $medication->quantity_left = $request->quantity_left;
                $medication->save();
                return $base->sendResponse(null, 'Medication Updated');
            } else {
                return $base->sendError('Medication Not Found');
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return $base->sendError('Internal Server Error');
        }
    }

    public function change_status(Request $request)
    {
        $request->validate([
            'medication_id' => 'required|exists:medications,id',
        ]);
        $id = $request->medication_id;
        $record = medication::FindOrFail($id);
        if ($record != null) {
            if ($record->status == 'active') {
                $record->status = 'inactive';
                $record->discontinue_date = $request->discontinue_date;
                $record->discontinue_reason = $request->discontinue_reason;
            } else {
                $record->status = 'active';
                $record->discontinue_date = null;
                $record->discontinue_reason = null;
            }
            $record->save();
            return response()->json([
                'code' => 200,
                'message' => 'Status Changed'
            ], 200);
        } else {
            return response()->json([
                'code' => 404,
                'message' => 'Record Not Found'
            ], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(medication $medication)
    {
        $base = new BaseController();
        $medication->delete();
        return $base->sendResponse([], 'Medication deleted successfully');
    }
}
