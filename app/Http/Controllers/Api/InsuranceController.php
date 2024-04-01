<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\API\BaseController as BaseController;
use App\Http\Requests\InsuranceRequest;
use App\Models\Insurance;
use Illuminate\Support\Facades\Log;

class InsuranceController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index($patient_id)
    {
        $insurance = Insurance::where('patient_id', $patient_id)->orderBy('created_at', 'DESC')->get();
        $base = new BaseController();
        if (count($insurance) > 0) {
            return $base->sendResponse($insurance, 'Insurance Data');
        } else {
            $insurance = NULL;
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
    public function store(InsuranceRequest $request)
    {
        $validatedData = $request->validated();
        $base = new BaseController();
        try {
            $validatedData['provider_id'] = auth()->user()->id;
            $validatedData['patient_id'] = $request->patient_id;
            $insurance = Insurance::create($validatedData);
            return $base->sendResponse($insurance, 'Insurance created successfully');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            $insurance = [];
            return $base->sendError($insurance, 'Internal Server Error');
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(Insurance $insurance)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Insurance $insurance)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(InsuranceRequest $request, Insurance $insurance)
    {

        $validatedData = $request->validated();
        $base = new BaseController();
        try {
            $insurance = Insurance::find($request->insurance_id);
            if ($insurance != NULL) {
                $insurance->update($validatedData);
                return $base->sendResponse($insurance, 'Insurance updated successfully');
            } else {
                $insurance = [];
                return $base->sendError($insurance, 'No Record Found');
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            $insurance = [];
            return $base->sendError($insurance, 'Internal Server Error');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Insurance $insurance)
    {
        $base = new BaseController();
        $insurance->delete();
        return $base->sendResponse([], 'Insurance deleted successfully');

    }

}
