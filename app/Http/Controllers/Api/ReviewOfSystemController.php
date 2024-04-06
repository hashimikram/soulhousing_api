<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController as BaseController;
use App\Models\ReviewOfSystem;
use Illuminate\Http\Request;

class ReviewOfSystemController extends BaseController
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
    public function store(Request $request)
    {
        try {
            $providerId = auth()->id();

            // Create a new ReviewOfSystem instance
            $reviewOfSystem = new ReviewOfSystem();

            // Assign attributes
            $reviewOfSystem->provider_id = $providerId;
            $reviewOfSystem->patient_id = $request->patient_id;
            $reviewOfSystem->constitutional = $request->constitutional ?? 'All Good';
            $reviewOfSystem->heent = $request->heent ?? 'All Good';
            $reviewOfSystem->cv = $request->cv ?? 'All Good';
            $reviewOfSystem->gi = $request->gi ?? 'All Good';
            $reviewOfSystem->gu = $request->gu ?? 'All Good';
            $reviewOfSystem->musculoskeletal = $request->musculoskeletal ?? 'All Good';
            $reviewOfSystem->skin = $request->skin ?? 'All Good';
            $reviewOfSystem->psychiatric = $request->psychiatric ?? 'All Good';
            $reviewOfSystem->endocrine = $request->endocrine ?? 'All Good';
            $reviewOfSystem->physical_exam = $request->physical_exam ?? 'All Good';
            $reviewOfSystem->general_appearance = $request->general_appearance ?? 'All Good';
            $reviewOfSystem->head_and_neck = $request->head_and_neck ?? 'All Good';
            $reviewOfSystem->eyes = $request->eyes ?? 'All Good';
            $reviewOfSystem->ears = $request->ears ?? 'All Good';
            $reviewOfSystem->nose = $request->nose ?? 'All Good';
            $reviewOfSystem->mouth_and_throat = $request->mouth_and_throat ?? 'All Good';
            $reviewOfSystem->cardiovascular = $request->cardiovascular ?? 'All Good';
            $reviewOfSystem->respiratory_system = $request->respiratory_system ?? 'All Good';
            $reviewOfSystem->abdomen = $request->abdomen ?? 'All Good';
            $reviewOfSystem->musculoskeletal_system = $request->musculoskeletal_system ?? 'All Good';
            $reviewOfSystem->neurological_system = $request->neurological_system ?? 'All Good';
            $reviewOfSystem->genitourinary_system = $request->genitourinary_system ?? 'All Good';
            $reviewOfSystem->psychosocial_assessment = $request->psychosocial_assessment ?? 'All Good';

            // Save the ReviewOfSystem instance
            $reviewOfSystem->save();
            $base = new BaseController();
            return $base->sendResponse(null, 'Data Added');
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }

    }

    /**
     * Display the specified resource.
     */
    public function show($patient_id)
    {
        $data = ReviewOfSystem::where('patient_id', $patient_id)->get();
        if (count($data) > 0) {
            $base = new BaseController();
            return $base->sendResponse($data, 'Data Fetch');
        } else {
            return response()->json(['data' => 'No Record Found']);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        try {
            // Create a new ReviewOfSystem instance
            $reviewOfSystem = ReviewOfSystem::find($request->id);
            // Assign attributes
            $reviewOfSystem->constitutional = $request->constitutional ?? 'All Good';
            $reviewOfSystem->heent = $request->heent ?? 'All Good';
            $reviewOfSystem->cv = $request->cv ?? 'All Good';
            $reviewOfSystem->gi = $request->gi ?? 'All Good';
            $reviewOfSystem->gu = $request->gu ?? 'All Good';
            $reviewOfSystem->musculoskeletal = $request->musculoskeletal ?? 'All Good';
            $reviewOfSystem->skin = $request->skin ?? 'All Good';
            $reviewOfSystem->psychiatric = $request->psychiatric ?? 'All Good';
            $reviewOfSystem->endocrine = $request->endocrine ?? 'All Good';
            $reviewOfSystem->physical_exam = $request->physical_exam ?? 'All Good';
            $reviewOfSystem->general_appearance = $request->general_appearance ?? 'All Good';
            $reviewOfSystem->head_and_neck = $request->head_and_neck ?? 'All Good';
            $reviewOfSystem->eyes = $request->eyes ?? 'All Good';
            $reviewOfSystem->ears = $request->ears ?? 'All Good';
            $reviewOfSystem->nose = $request->nose ?? 'All Good';
            $reviewOfSystem->mouth_and_throat = $request->mouth_and_throat ?? 'All Good';
            $reviewOfSystem->cardiovascular = $request->cardiovascular ?? 'All Good';
            $reviewOfSystem->respiratory_system = $request->respiratory_system ?? 'All Good';
            $reviewOfSystem->abdomen = $request->abdomen ?? 'All Good';
            $reviewOfSystem->musculoskeletal_system = $request->musculoskeletal_system ?? 'All Good';
            $reviewOfSystem->neurological_system = $request->neurological_system ?? 'All Good';
            $reviewOfSystem->genitourinary_system = $request->genitourinary_system ?? 'All Good';
            $reviewOfSystem->psychosocial_assessment = $request->psychosocial_assessment ?? 'All Good';

            // Save the ReviewOfSystem instance
            $reviewOfSystem->save();
            $base = new BaseController();
            return $base->sendResponse(null, 'Data Updated');
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        ReviewOfSystem::destroy($id);
        $base = new BaseController();
        return $base->sendResponse(null, 'Data Deleted');
    }
}
