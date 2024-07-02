<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController as BaseController;
use App\Http\Requests\InsuranceRequest;
use App\Http\Requests\InsuranceUpdate;
use App\Models\Insurance;
use Illuminate\Support\Facades\DB;

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
            foreach ($insurance as $data) {
                if ($data->insurance_type == '1') {
                    $data['insurance_type'] = 'Primary';
                } elseif ($data->insurance_type == '2') {
                    $data['insurance_type'] = 'Secondary';
                } else {
                    $data['insurance_type'] = 'Teartiary';
                }
            }
            return $base->sendResponse($insurance, 'Insurance Data');
        } else {
            $insurance = null;
            return $base->sendError('No Record Found');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(InsuranceRequest $request)
    {
        // Validate the request data
        $validatedData = $request->validated();

        $user = auth()->user();
        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        $base = new BaseController();
        DB::beginTransaction();
        try {
            $validatedData['provider_id'] = $user->id;
            $insurance = Insurance::create($validatedData);
            DB::commit();
            return $base->sendResponse($insurance, 'Insurance created successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
            ], 500);
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
    public function update(InsuranceUpdate $request, Insurance $insurance)
    {
        $validatedData = $request->validated();
        $base = new BaseController();
        try {
            $insurance = Insurance::find($request->insurance_id);
            if ($insurance != null) {
                $insurance->update($validatedData);
                return $base->sendResponse($insurance, 'Insurance updated successfully');
            } else {
                $insurance = [];
                return $base->sendError($insurance, 'No Record Found');
            }
        } catch (\Exception $e) {
            $insurance = [];
            return $base->sendError($insurance, $e->getMessage());
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
