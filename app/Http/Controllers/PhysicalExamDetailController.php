<?php

namespace App\Http\Controllers;

use App\Models\PhysicalExamDetail;
use App\Http\Requests\StorePhysicalExamDetailRequest;
use App\Http\Requests\UpdatePhysicalExamDetailRequest;

class PhysicalExamDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function store(StorePhysicalExamDetailRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($section_id, $patient_id)
    {
        $data = PhysicalExamDetail::where('patient_id', $patient_id)->where('section_id', $section_id)->get();
        return response()->json([
            'code' => 'success',
            'data' => $data
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PhysicalExamDetail $physicalExamDetail)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePhysicalExamDetailRequest $request)
    {

        $physicalExamDetail = PhysicalExamDetail::find($request->id);
        if (!$physicalExamDetail) {
            return response()->json(['error' => 'Physical exam detail not found.'], 404);
        }
        $physicalExamDetail->constitutional = $request->input('constitutional', 'constitutional');
        $physicalExamDetail->ears_nose_mouth_throat = $request->input('ears_nose_mouth_throat');
        $physicalExamDetail->neck = $request->input('neck');
        $physicalExamDetail->respiratory = $request->input('respiratory');
        $physicalExamDetail->cardiovascular = $request->input('cardiovascular');
        $physicalExamDetail->lungs = $request->input('lungs');
        $physicalExamDetail->chest_breasts = $request->input('chest_breasts');
        $physicalExamDetail->heart = $request->input('heart');
        $physicalExamDetail->gastrointestinal_abdomen = $request->input('gastrointestinal_abdomen');
        $physicalExamDetail->genitourinary = $request->input('genitourinary');
        $physicalExamDetail->lymphatic = $request->input('lymphatic');
        $physicalExamDetail->musculoskeletal = $request->input('musculoskeletal');
        $physicalExamDetail->skin = $request->input('skin');
        $physicalExamDetail->extremities = $request->input('extremities');
        $physicalExamDetail->save();

        return response()->json(['message' => 'Physical exam detail updated successfully.']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PhysicalExamDetail $physicalExamDetail)
    {
        //
    }
}
