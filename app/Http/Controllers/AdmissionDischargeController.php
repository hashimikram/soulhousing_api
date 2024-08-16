<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAdmissionDischargeRequest;
use App\Http\Requests\UpdateAdmissionDischargeRequest;
use App\Models\AdmissionDischarge;
use Illuminate\Support\Facades\DB;

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
            $result->patient_name = $result->patient->first_name.' '.$result->patient->last_name;
            $result->patient_date_of_birth = $result->patient->date_of_birth;
            $result->patient_medical_id = $result->patient->medical_no;

            $result->staff_name = $result->staff->name.' '.$result->staff->details->last_name;
            $result->position = $result->staff->user_type;

            $result->soul_housing_address = 'UK';
            $result->soul_housing_phone = '+09837656728';
            $result->website = 'https://care-soulhousing.anchorstech.net/';
            $result->registered_type = true;
        }
        return response()->json([
            'success' => true,
            'data' => $data
        ], 200);
    }

    public function discharged_patients($patient_id)
    {
        $data = AdmissionDischarge::join('facilities', 'facilities.id', '=',
            'admission_discharges.admission_location')->select('facilities.address as location',
            'admission_discharges.*')->where('admission_discharges.patient_id',
            $patient_id)->where('admission_discharges.status', '0')->get();
        foreach ($data as $result) {

            $result->registered_type = false;
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
            $store_admission->save();
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Data Added'
            ], 200);
        } catch (\Exception $e) {
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
        } catch (\Exception $e) {
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
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['error' => 'Vital not found'], 404);
        }

        // 4. Attempt to delete the note
        try {
            $record->delete();
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }

        // 5. Return success response
        return response()->json(['message' => 'Data deleted successfully'], 200);
    }

    public function discharge_patient($id)
    {
        try {
            $record = AdmissionDischarge::findOrFail($id);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['error' => 'Vital not found'], 404);
        }
        try {
            $record->status = '0';
            $record->save();
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
        return response()->json(['message' => 'patients Discharged Successfully'], 200);
    }
}
