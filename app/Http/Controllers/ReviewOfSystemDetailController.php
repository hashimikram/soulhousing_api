<?php

namespace App\Http\Controllers;

use App\Models\ReviewOfSystemDetail;
use App\Http\Requests\StoreReviewOfSystemDetailRequest;
use App\Http\Requests\UpdateReviewOfSystemDetailRequest;
use App\Models\ReviewOfSystem;

class ReviewOfSystemDetailController extends Controller
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
    public function store(StoreReviewOfSystemDetailRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($section_id, $patient_id)
    {
        $data = ReviewOfSystemDetail::where('patient_id', $patient_id)->where('section_id', $section_id)->first();
        return response()->json([
            'code' => 'success',
            'data' => $data
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ReviewOfSystemDetail $reviewOfSystemDetail)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateReviewOfSystemDetailRequest $request)
    {
        $reviewOfSystemDetail = ReviewOfSystemDetail::FindOrFail($request->id);
        if (!isset($reviewOfSystemDetail)) {
            return response()->json([
                'code' => 'success',
                'message' => 'Data Not Found',
            ]);
        }
        if (!$reviewOfSystemDetail) {
            return response()->json(['error' => 'Review of system detail not found.'], 404);
        }

        $reviewOfSystemDetail->general = $request->input('general');
        $reviewOfSystemDetail->skin = $request->input('skin');
        $reviewOfSystemDetail->head = $request->input('head');
        $reviewOfSystemDetail->eyes = $request->input('eyes');
        $reviewOfSystemDetail->ears = $request->input('ears');
        $reviewOfSystemDetail->nose = $request->input('nose');
        $reviewOfSystemDetail->mouth_throat = $request->input('mouth_throat');
        $reviewOfSystemDetail->neck = $request->input('neck');
        $reviewOfSystemDetail->breasts = $request->input('breasts');
        $reviewOfSystemDetail->respiratory = $request->input('respiratory');
        $reviewOfSystemDetail->cardiovascular = $request->input('cardiovascular');
        $reviewOfSystemDetail->gastrointestinal = $request->input('gastrointestinal');
        $reviewOfSystemDetail->genitourinary = $request->input('genitourinary');
        $reviewOfSystemDetail->musculoskeletal = $request->input('musculoskeletal');
        $reviewOfSystemDetail->neurological = $request->input('neurological');
        $reviewOfSystemDetail->psychiatric = $request->input('psychiatric');
        $reviewOfSystemDetail->endocrine = $request->input('endocrine');
        $reviewOfSystemDetail->hematologic_lymphatic = $request->input('hematologic_lymphatic');
        $reviewOfSystemDetail->allergic_immunologic = $request->input('allergic_immunologic');
        $reviewOfSystemDetail->save();

        return response()->json(['message' => 'Review of system detail updated successfully.']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ReviewOfSystemDetail $reviewOfSystemDetail)
    {
        //
    }
}
