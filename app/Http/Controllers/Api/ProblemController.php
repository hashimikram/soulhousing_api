<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController as BaseController;
use App\Models\Problem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

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
        $request->validate([
            'diagnosis' => 'required',
            'cd_description' => 'required',
            'comments' => 'required',
        ]);
        $validatedData = $request->all();
        $base = new BaseController();
        try {
            $validatedData['provider_id'] = auth()->user()->id;
            $validatedData['patient_id'] = $request->patient_id;
            $insurance = Problem::create($validatedData);
            return $base->sendResponse($insurance, 'Problem created successfully');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            $contact = [];
            return $base->sendError($contact, 'Internal Server Error');
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
        $request->validate([
            'diagnosis' => 'required',
            'cd_description' => 'required',
            'comments' => 'required',
        ]);
        $validatedData = $request->all();
        $base = new BaseController();
        try {
            $problem = Problem::find($request->problem_id);
            if ($problem != NULL) {
                $problem->update($validatedData);
                return $base->sendResponse($problem, 'Problem updated successfully');
            } else {
                $problem = [];
                return $base->sendError($problem, 'No Record Found');
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            $problem = [];
            return $base->sendError($problem, 'Internal Server Error');
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
