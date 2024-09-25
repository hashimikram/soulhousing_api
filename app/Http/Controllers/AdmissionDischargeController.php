<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Api\BaseController as BaseController;
use App\Http\Requests\StoreAdmissionDischargeRequest;
use App\Http\Requests\UpdateAdmissionDischargeRequest;
use App\Models\AdmissionDischarge;
use App\Models\bed;
use App\Models\DischargedPatients;
use App\Models\floor;
use App\Models\patient;
use App\Models\room;
use App\Models\WebsiteSetting;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PDF;

class AdmissionDischargeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($patient_id)
    {
        $data = AdmissionDischarge::leftjoin('facilities', 'facilities.id', '=',
            'admission_discharges.admission_location')->select('facilities.address as location',
            'admission_discharges.*')->where('admission_discharges.patient_id',
            $patient_id)->where('admission_discharges.status', '1')->get();
        foreach ($data as $result) {
            $result->patient_name = $result->patient->first_name . ' ' . $result->patient->last_name;
            $result->patient_date_of_birth = $result->patient->date_of_birth;
            $result->patient_medical_id = $result->patient->medical_no;

            $result->staff_name = $result->staff->name . ' ' . $result->staff->details->last_name;
            $result->position = $result->staff->user_type;
            $settings = WebsiteSetting::whereIn('key', ['platform_name', 'platform_address', 'platform_contact'])->pluck('value', 'key');
            $result->soul_housing_address = $settings['platform_address'] ?? '';
            $result->soul_housing_phone = $settings['platform_contact'] ?? '';
            $result->website = $settings['platform_name'] ?? '';
            $result->registered_type = true;

            $result->bed_name = bed::where('id', $result->bed_id)->first()->bed_title ?? '';
            $result->room_name = room::where('id', $result->room_id)->first()->room_name ?? '';
            $result->floor_name = floor::where('id', $result->floor_id)->first()->floor_name ?? '';
        }
        return response()->json([
            'success' => true,
            'data' => $data
        ], 200);
    }

    public function discharged_patients($patient_id)
    {
        $data = AdmissionDischarge::leftjoin('facilities', 'facilities.id', '=',
            'admission_discharges.admission_location')->select('facilities.address as location',
            'admission_discharges.*')->where('admission_discharges.patient_id',
            $patient_id)->where('admission_discharges.status', '0')->get();
        foreach ($data as $result) {
            $result->registered_type = false;
            $result->bed_name = bed::where('id', $result->bed_id)->first()->bed_title ?? '';
            $result->room_name = room::where('id', $result->room_id)->first()->room_name ?? '';
            $result->floor_name = floor::where('id', $result->floor_id)->first()->floor_name ?? '';
        }
        return response()->json([
            'success' => true,
            'data' => $data
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $admission_types = AdmissionDischarge::where('option_id', 'Admission_Type')->get();
        return response()->json([
            'success' => true,
            'admission_types' => $admission_types
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAdmissionDischargeRequest $request)
    {

        try {
            $existing_record = AdmissionDischarge::where('patient_id', $request->patient_id)->where('status',
                '1')->first();
            if (isset($existing_record)) {
                return response()->json([
                    'status' => true,
                    'message' => 'patients Already Admitted'
                ], 404);
            }
            DB::beginTransaction();
            $value_new_admission = ($request->new_admission === true) ? 'Yes' : 'No';
            $value_pan_patient = ($request->pan_patient === true) ? 'Yes' : 'No';
            $store_admission = new AdmissionDischarge();
            $store_admission->provider_id = auth()->user()->id;
            $store_admission->patient_id = $request->patient_id;
            $store_admission->admission_date = $request->admission_date;
            $store_admission->admission_location = $request->admission_location;
            $store_admission->room_no = $request->room_no;
            $store_admission->patient_type = $request->patient_type;
            $store_admission->admission_type = $request->admission_type;
            $store_admission->admission_service = $request->admission_service;
            $store_admission->discharge_date = $request->discharge_date;
            $store_admission->new_admission = $value_new_admission;
            $store_admission->pan_patient = $value_pan_patient;
            $store_admission->patient_account_number = $request->patient_account_number;
            $store_admission->facility_id = current_facility(auth()->user()->id);
            if ($request->bed_id) {
                $store_admission->bed_id = $request->bed_id;
                $store_admission->room_id = room::where('id', bed::where('id', $request->bed_id)->first()->room_id)->first()->id;
                $store_admission->floor_id = floor::where('id', room::where('id', bed::where('id', $request->bed_id)->first()->room_id)->first()->floor_id)->first()->id;
            }
            $store_admission->save();
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Data Added'
            ], 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 200);
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(AdmissionDischarge $admissionDischarge)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AdmissionDischarge $admissionDischarge)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAdmissionDischargeRequest $request, AdmissionDischarge $admissionDischarge)
    {
        try {
            DB::beginTransaction();
            $fetch_record = AdmissionDischarge::FindOrFail($request->admission_id);
            if (isset($fetch_record)) {
                $value_new_admission = ($request->new_admission === true) ? 'Yes' : 'No';
                $value_pan_patient = ($request->pan_patient === true) ? 'Yes' : 'No';
                $fetch_record->admission_date = $request->admission_date;
                $fetch_record->admission_location = $request->admission_location;
                $fetch_record->room_no = $request->room_no;
                $fetch_record->patient_type = $request->patient_type;
                $fetch_record->admission_type = $request->admission_type;
                $fetch_record->admission_service = $request->admission_service;
                $fetch_record->new_admission = $value_new_admission;
                $fetch_record->pan_patient = $value_pan_patient;
                $fetch_record->patient_account_number = $request->patient_account_number;
                $fetch_record->discharge_date = $request->discharge_date;
                $fetch_record->new_room = $request->new_room;
                $fetch_record->discharge_type = $request->discharge_type;
                $fetch_record->comments = $request->comments;
                $fetch_record->save();
                return response()->json([
                    'success' => true,
                    'message' => 'Data Updated'
                ], 200);
            } else {
                return response()->json([
                    'success' => true,
                    'message' => 'Data Not Found'
                ], 404);
            }
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 200);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        if (!is_numeric($id) || $id <= 0) {
            return response()->json(['error' => 'Invalid Vital ID'], 400);
        }

        try {
            $record = AdmissionDischarge::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Vital not found'], 404);
        }

        // 4. Attempt to delete the note
        try {
            $record->delete();
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }

        // 5. Return success response
        return response()->json(['message' => 'Data deleted successfully'], 200);
    }

    public function discharge_patient($id)
    {
        try {
            $record = AdmissionDischarge::findOrFail($id);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Vital not found'], 404);
        }
        try {
            $record->status = '0';
            $record->save();
            $bed = bed::where('id', $record->bed_id)->first();
            if ($bed) {
                $bed->status = 'unprepared';
                $bed->patient_id = null;
                $bed->occupied_from = null;
                $bed->booked_till = null;
                $bed->save();
            }
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
        return response()->json(['message' => 'patients Discharged Successfully'], 200);
    }

    public function get_vacant_beds()
    {
        try {
            $floors = floor::where('facility_id', current_facility(auth()->user()->id))->get();
            $response = []; // Initialize the response array here
            $status = 'vacant';
            $base = new BaseController();
            foreach ($floors as $details) {
                $rooms = Room::where('floor_id', $details->id)->with([
                    'beds' => function ($query) use ($status) {
                        $query->where('status', $status)->select('beds.id', 'beds.status', 'beds.bed_title',
                            'beds.room_id', 'beds.patient_id', 'beds.occupied_from')
                            ->with(['patient:id,first_name,last_name,gender,date_of_birth,mrn_no']);
                    }
                ])->get();

                foreach ($rooms as $room) {
                    $floor = floor::where('id', $room->floor_id)->first();
                    foreach ($room->beds as $bed) {
                        if ($bed->status == 'vacant') {
                            $bedData = [
                                'id' => $bed->id,
                                'status' => $bed->status,
                                'bed_title' => $bed->bed_title,
                                'room_id' => $bed->room_id,
                                'patient_id' => $bed->patient_id,
                                'occupied_from' => $bed->occupied_from,
                                'floor_name' => $floor->floor_name,
                                'room_name' => $room->room_name,
                                'created_at' => $room->created_at,
                                'updated_at' => $room->updated_at,
                            ];

                            $response[] = $bedData;
                        }
                    }
                }
            }

            return $base->sendResponse($response, 'Beds with status "' . $status . '" retrieved successfully');
        } catch (Exception $e) {
            return $base->sendError('Error', $e->getMessage());
        }
    }

    public function close_admission(Request $request)
    {
        $request->validate([
            'bed_id' => 'required|exists:beds,id',
        ]);
        $bed = bed::where(['id' => $request->bed_id])->first();
        if (isset($bed)) {
            $bed->patient_id = null;
            $bed->status = 'vacant';
            $bed->occupied_from = null;
            $bed->booked_till = null;
            $bed->save();
            return response()->json([
                'code' => 'true',
                'message' => 'Bed Closed Successfully',
            ], 200);
        } else {
            return response()->json([
                'code' => 'false',
                'message' => 'Bed Not Found',
            ], 404);
        }
    }

    public function get_pdf($admission_id)
    {
        try {
            $patient_admission = AdmissionDischarge::with(['staff', 'facility'])->where('id', $admission_id)->first();
            $discharged_patient = DischargedPatients::where('admission_id', $patient_admission->id)->first();
            $patient = patient::where('id', $patient_admission->patient_id)->first();
            $pdf = PDF::loadView('PDF.discharge_pdf', compact('patient_admission', 'discharged_patient', 'patient'));
//        return $pdf->stream('discharge_patient.pdf');
            $pdfContent = $pdf->output();
            $base64file = base64_encode($pdfContent);
            $mimeType = 'application/pdf';
            return response()->json([
                'file' => $base64file,
                'mime_type' => $mimeType
            ]);
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }

    }
}
