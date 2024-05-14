<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController as BaseController;

use App\Models\bed;
use App\Models\patient;
use Illuminate\Http\Request;

class BedController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function assign_bed(Request $request)
    {
        $request->validate([
            'bed_id' => 'required|exists:beds,id',
            'patient_id' => 'required|exists:patients,id',
        ]);
        $beds = Bed::where('id', $request->bed_id)->first();
        if ($beds != NULL) {
            try {
                date_default_timezone_set('Asia/Karachi');
                $checkAssignBed = Bed::where(['patient_id' => $request->patient_id])->first();
                if (isset($checkAssignBed)) {
                    return response()->json([
                        'code' => false,
                        'message' => 'Patient Already Assigned',
                    ], 200);
                } else {
                    $occupied_at = date('Y-m-d h:i:s', strtotime($request->occupied_at));
                    $booked_till = date('Y-m-d h:i:s', strtotime($request->booked_till));
                    $beds->patient_id = $request->patient_id;
                    $beds->occupied_from = $occupied_at;
                    $beds->booked_till = $booked_till;
                    $beds->status = 'occupied';
                    $beds->save();
                    return response()->json([
                        'code' => true,
                        'message' => 'Patient Added',
                    ], 200);
                }
            } catch (\Exception $e) {
                return response()->json([
                    'code' => false,
                    'message' => $e->getMessage(),
                ], 200);
            }
        } else {
            return response()->json([
                'code' => 'false',
                'message' => 'Bed Not Found',
            ], 404);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function update_patient_bed(Request $request)
    {
        $request->validate([
            'bed_id' => 'required|exists:beds,id',
            'patient_id' => 'required|exists:patients,id',
        ]);
        $bed = Bed::where(['id' => $request->bed_id])->first();
        if (isset($bed)) {
            $bed->patient_id = $request->patient_id;
            $bed->save();
            return response()->json([
                'code' => true,
                'message' => 'Patient Added',
            ], 200);
        } else {
            return response()->json([
                'code' => 'false',
                'message' => 'Bed Not Found',
            ], 404);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $bed = bed::where('id', $id)->first();
        if ($bed != NULL) {
            $patient = patient::where('id', $bed->patient_id)->select('first_name', 'last_name', 'gender', 'date_of_birth', 'mrn_no')->first();
            return response()->json([
                'code' => true,
                'data' => $patient,
            ], 200);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(bed $bed)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, bed $bed)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(bed $bed)
    {
        //
    }
}
