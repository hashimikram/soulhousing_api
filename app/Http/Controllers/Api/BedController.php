<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController as BaseController;
use App\Models\bed;
use App\Models\patient;
use Exception;
use Illuminate\Http\Request;

class BedController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
//    public function assign_bed(Request $request)
//    {
//        $request->validate([
//            'bed_id' => 'required|exists:beds,id',
//            'patient_id' => 'required|exists:patients,id',
//        ]);
//        $beds = Bed::where('id', $request->bed_id)->first();
//        if ($beds != null) {
//            try {
//                $checkAssignBed = Bed::where(['patient_id' => $request->patient_id, 'id' => $request->bed_id, 'status' => 'occupied'])->first();
//                Log::info($checkAssignBed);
//                if (isset($checkAssignBed)) {
//                    return response()->json([
//                        'code' => false,
//                        'bed_assigned' => false,
//                        'status' => '1',
//                        'message' => 'patients Already Assigned',
//                    ], 200);
//                } else {
//                    $occupied_at = date('Y-m-d h:i:s', strtotime($request->occupied_at));
//                    $booked_till = date('Y-m-d h:i:s', strtotime($request->booked_till));
//                    $beds->patient_id = $request->patient_id;
//                    $beds->occupied_from = $occupied_at;
//                    $beds->booked_till = $booked_till;
//                    $beds->status = 'occupied';
//                    $beds->save();
//                    $data = [
//                        'bed_title' => $beds->bed_title,
//                        'bed_id' => $beds->id,
//                        'room_name' => $beds->room->room_name,
//                        'floor_name' => $beds->room->floor->floor_name,
//                    ];
//                    return response()->json([
//                        'code' => true,
//                        'bed_assigned' => true,
//                        'assigned_data' => $data,
//                        'message' => 'patients Added',
//                    ], 200);
//                }
//            } catch (Exception $e) {
//                return response()->json([
//                    'code' => false,
//                    'bed_assigned' => false,
//                    'message' => $e->getMessage(),
//                ], 200);
//            }
//        } else {
//            return response()->json([
//                'code' => 'false',
//                'message' => 'Bed Not Found',
//            ], 404);
//        }
//    }

    public function assign_bed(Request $request)
    {
        $request->validate([
            'bed_id' => 'required|exists:beds,id',
            'patient_id' => 'required|exists:patients,id',
        ]);

        $bed = Bed::where('id', $request->bed_id)->first();

        if ($bed != null) {
            try {
                // Check if the bed is already assigned to any patient
                if ($bed->patient_id != null) {
                    return response()->json([
                        'code' => false,
                        'bed_assigned' => false,
                        'status' => '1',
                        'message' => 'Bed already assigned to another patient',
                    ], 200);
                }

                // Check if the patient is already assigned to any bed
                $patientBed = Bed::where('patient_id', $request->patient_id)->first();
                if ($patientBed != null) {
                    return response()->json([
                        'code' => false,
                        'bed_assigned' => false,
                        'status' => '1',
                        'message' => 'Patient already assigned to another bed',
                    ], 200);
                }

                // Proceed to assign bed to patient
                $occupied_at = date('Y-m-d H:i:s', strtotime($request->occupied_at));
                $booked_till = date('Y-m-d H:i:s', strtotime($request->booked_till));
                $bed->patient_id = $request->patient_id;
                $bed->occupied_from = $occupied_at;
                $bed->booked_till = $booked_till;
                $bed->status = 'occupied';
                $bed->save();

                $data = [
                    'bed_title' => $bed->bed_title,
                    'bed_id' => $bed->id,
                    'room_name' => $bed->room->room_name,
                    'floor_name' => $bed->room->floor->floor_name,
                ];

                return response()->json([
                    'code' => true,
                    'bed_assigned' => true,
                    'assigned_data' => $data,
                    'message' => 'Patient assigned to bed',
                ], 200);
            } catch (Exception $e) {
                return response()->json([
                    'code' => false,
                    'bed_assigned' => false,
                    'message' => $e->getMessage(),
                ], 200);
            }
        } else {
            return response()->json([
                'code' => false,
                'message' => 'Bed not found',
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
        $bed = bed::where(['patient_id' => $request->patient_id])->first();
        if (isset($bed)) {
            // remove old patients and make Bed Empty
            $bed->patient_id = null;
            $bed->status = 'vacant';
            $bed->occupied_from = null;
            $bed->booked_till = null;
            $bed->save();

            // add to new bed
            $newBed = bed::find($request->bed_id);
            $newBed->patient_id = $request->patient_id;
            $newBed->status = 'occupied';
            $newBed->save();
            $data = [
                'bed_title' => $newBed->bed_title,
                'bed_id' => $newBed->id,
                'room_name' => $newBed->room->room_name,
                'floor_name' => $newBed->room->floor->floor_name,
            ];
            return response()->json([
                'code' => true,
                'bed_assigned' => true,
                'assigned_data' => $data,
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
        } catch (Exception $e) {
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

        } catch (Exception $e) {
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
                $bed->status = 'unprepared';
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
        } catch (Exception $e) {
            return response()->json([
                'code' => 'false',
                'message' => $e->getMessage(),
            ], 500);
        }

    }

    public function markAsVacant(Request $request)
    {
        $request->validate([
            'bed_id' => 'required|exists:beds,id',
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
                    'message' => 'Bed Updated',
                ], 200);
            } else {
                return response()->json([
                    'code' => 'false',
                    'message' => 'Bed Not Found',
                ], 404);
            }
        } catch (Exception $e) {
            return response()->json([
                'code' => 'false',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function markAsHospitalized(Request $request)
    {
        $request->validate([
            'bed_id' => 'required|exists:beds,id',
        ]);
        try {
            $bed = bed::where(['id' => $request->bed_id])->first();
            if (isset($bed)) {
                $bed->status = 'hospitalized';
                $bed->save();
                return response()->json([
                    'code' => true,
                    'message' => 'Bed Updated',
                ], 200);
            } else {
                return response()->json([
                    'code' => 'false',
                    'message' => 'Bed Not Found',
                ], 404);
            }
        } catch (Exception $e) {
            return response()->json([
                'code' => 'false',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function markAsReassign(Request $request)
    {
        $request->validate([
            'bed_id' => 'required|exists:beds,id',
        ]);
        try {
            $bed = bed::where(['id' => $request->bed_id])->first();
            if (isset($bed)) {
                $bed->occupied_from = now();
                $bed->booked_till = now()->addDays(90);
                $bed->status = 'occupied';
                $bed->save();
                return response()->json([
                    'code' => true,
                    'message' => 'Bed Updated',
                ], 200);
            } else {
                return response()->json([
                    'code' => 'false',
                    'message' => 'Bed Not Found',
                ], 404);
            }
        } catch (Exception $e) {
            return response()->json([
                'code' => 'false',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
