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
        if ($beds != null) {
            try {
                $checkAssignBed = Bed::where(['patient_id' => $request->patient_id])->first();
                if (isset($checkAssignBed)) {
                    return response()->json([
                        'code' => false,
                        'status' => '1',
                        'message' => 'patients Already Assigned',
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
                        'message' => 'patients Added',
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
        $bed = Bed::where(['patient_id' => $request->patient_id])->first();
        if (isset($bed)) {
            // remove old patients and make Bed Empty
            $bed->patient_id = null;
            $bed->status = 'vacant';
            $bed->occupied_from = null;
            $bed->booked_till = null;
            $bed->save();

            // add to new bed
            $newBed = Bed::find($request->bed_id);
            $newBed->patient_id = $request->patient_id;
            $newBed->status = 'occupied';
            $newBed->save();
            return response()->json([
                'code' => true,
                'message' => 'patients Added',
            ], 200);

            $bed->patient_id = $request->patient_id;
            $bed->save();
            return response()->json([
                'code' => true,
                'message' => 'patients Added',
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
        $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'bed_title' => 'required',
        ]);
        try {
            $bed = new bed();
            $bed->room_id = $request->room_id;
            $bed->bed_title = $request->bed_title;
            $bed->status = 'vacant';
            $bed->save();
            return response()->json([
                'success' => true,
                'message' => 'Bed Added Successfully'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $bed = bed::where('id', $id)->first();
        if ($bed != null) {
            $patient = patient::where('id', $bed->patient_id)->select('first_name', 'last_name', 'gender',
                'date_of_birth', 'mrn_no')->first();
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
    public function update(Request $request)
    {
        $request->validate([
            'bed_id' => 'required|exists:beds,id',
            'bed_title' => 'required',
        ]);
        try {
            $bed = bed::FindOrFail($request->bed_id);
            if (isset($bed)) {
                $bed->bed_title = $request->bed_title;
                $bed->save();
                return response()->json([
                    'success' => true,
                    'message' => 'Bed Title Updated Successfully'
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Data Not Found'
                ], 404);
            }

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete_bed($bed_id)
    {
        $bed = bed::FindOrFail($bed_id);
        $bed->delete();
        return response()->json([
            'success' => true,
            'message' => 'Bed Deleted'
        ], 200);
    }

    public function discharge_patient_bed(Request $request)
    {
        $request->validate([
            'bed_id' => 'required|exists:beds,id',
            'patient_id' => 'required|exists:patients,id',
        ]);
        try {
            $bed = bed::where(['id' => $request->bed_id])->first();
            if (isset($bed)) {
                $bed->patient_id = null;
                $bed->status = 'vacant';
                $bed->occupied_from = null;
                $bed->booked_till = null;
                $bed->save();
                return response()->json([
                    'code' => true,
                    'message' => 'patients DisCharged',
                ], 200);
            } else {
                return response()->json([
                    'code' => 'false',
                    'message' => 'Bed Not Found',
                ], 404);
            }
        } catch (\Exception $e) {
            return response()->json([
                'code' => 'false',
                'message' => $e->getMessage(),
            ], 500);
        }

    }
}
