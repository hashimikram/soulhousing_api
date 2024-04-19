<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController as BaseController;
use App\Http\Requests\MedicationRequest;
use App\Models\medication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MedicationController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index($id)
    {
        $medication = medication::with('patients')->where('patient_id', $id)->get();
        $base = new BaseController();
        return $base->sendResponse($medication, 'Medication Data');
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
            $medication->user_free_text = $request->user_free_text;
            $medication->prescribe_date = $request->prescribe_date;
            $medication->action = $request->action;
            $medication->quantity = $request->quantity;
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
            $medication->save();
            return $base->sendResponse(Null, 'Medication Added');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return $base->sendError('Internal Server Error');
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
            'prescribe_date' => 'required|date',
            'days_supply' => 'required',
            'refills' => 'required',
            'dispense' => 'required',
            'dispense_unit' => 'required',
            'primary_diagnosis' => 'required',
            'secondary_diagnosis' => 'required',
            'patient_directions' => 'required',
        ]);
        $base = new BaseController();
        try {
            $medication = medication::find($request->id);
            if ($medication != NULL) {
                $medication->favourite_medication = $request->favourite_medication;
                $medication->user_free_text = $request->user_free_text;
                $medication->prescribe_date = $request->prescribe_date;
                $medication->action = $request->action;
                $medication->quantity = $request->quantity;
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
                $medication->save();
                return $base->sendResponse(Null, 'Medication Updated');
            } else {
                return $base->sendError('Medication Not Found');
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return $base->sendError('Internal Server Error');
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
