<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController as BaseController;
use App\Models\patient;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PatientController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $patients = patient::where('provider_id', auth()->user()->id)->orderBy('created_at', 'DESC')->get();
        $base = new BaseController();
        return $base->sendResponse($patients, 'All Patients Of Login Provider');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function check_availablity(Request $request)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'gender' => 'required',
            'date_of_birth' => 'required',
        ]);
        $checkUniuqe = patient::where('first_name', $request->first_name)
            ->where('last_name', $request->last_name)
            ->where('gender', $request->gender)
            ->where('date_of_birth', $request->date_of_birth)
            ->get();
        $base = new BaseController();
        if (count($checkUniuqe) == 0) {
            return $base->sendResponse(NULL, 'No Patient Found');
        } else {
            return $base->sendError('Patient Already Exists');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'ssn' => 'required',
            'gender' => 'required',
            'email' => 'unique:patients,email,except,id',
            'phone_no' => 'required|unique:patients,phone_no,except,id',
        ]);
        $base = new BaseController();
        try {
            $currentMonth = Carbon::now()->format('m');
            $totalPatient = patient::whereMonth('created_at', $currentMonth)->count();
            $countone = 1;
            $countPatient = date('ym') . $totalPatient + $countone;
            $patient = new patient();
            $patient->provider_id = auth()->user()->id;
            $patient->patient_id = $countPatient;
            $patient->first_name = $request->first_name;
            $patient->middle_name = $request->middle_name;
            $patient->last_name = $request->last_name;
            $patient->nick_name = $request->nick_name;
            $patient->phone_no = $request->phone_no;
            $patient->email = $request->email;
            $patient->suffix = $request->suffix;
            $patient->ssn = $request->ssn;
            $patient->gender = $request->gender;
            $patient->date_of_birth = $request->date_of_birth;
            $patient->general_identity = $request->general_identity;
            $patient->other = $request->other;
            $patient->location = $request->location;
            $patient->pharmacy = $request->pharmacy;
            $patient->address_1 = $request->address_1;
            $patient->address_2 = $request->address_2;
            $patient->city = $request->city;
            $patient->state = $request->state;
            $patient->zip_code = $request->zip_code;
            $patient->country = $request->country;
            $patient->save();
            $data['patient_id'] = $patient->id;
            return $base->sendResponse($data, 'Patient Added Successfully');
        } catch (\Exception $e) {

            return $base->sendError($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($patientId)
    {
        $patient = Patient::find($patientId);
        if (!$patient) {
            return response()->json(['message' => 'Patient not found'], 404);
        }
        $base = new BaseController();
        return $base->sendResponse($patient, 'Patient Detail of ID ' . $patient->id);
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(patient $patient)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, patient $patient)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'ssn' => 'required',
            'gender' => 'required',
            'phone_no' => 'required',
        ]);
        $base = new BaseController();

        try {
            $currentMonth = Carbon::now()->format('m');
            $totalPatient = patient::whereMonth('created_at', $currentMonth)->count();
            $countone = 1;
            $countPatient = date('ym') . $totalPatient + $countone;
            $patient = patient::find($request->id);
            if ($patient != NULL) {
                $patient->first_name = $request->first_name;
                $patient->middle_name = $request->middle_name;
                $patient->last_name = $request->last_name;
                $patient->nick_name = $request->nick_name;
                $patient->phone_no = $request->phone_no;
                $patient->email = $request->email;
                $patient->suffix = $request->suffix;
                $patient->ssn = $request->ssn;
                $patient->gender = $request->gender;
                $patient->date_of_birth = $request->date_of_birth;
                $patient->general_identity = $request->general_identity;
                $patient->other = $request->other;
                $patient->location = $request->location;
                $patient->pharmacy = $request->pharmacy;
                $patient->address_1 = $request->address_1;
                $patient->address_2 = $request->address_2;
                $patient->city = $request->city;
                $patient->state = $request->state;
                $patient->suffix_1 = $request->suffix_1;
                $patient->ssn_1 = $request->ssn_1;
                $patient->zip_code = $request->zip_code;
                $patient->country = $request->country;
                $patient->save();
                $data['patient_id'] = $patient->id;
                return $base->sendResponse($data, 'Patient Updated Successfully');
            } else {
                return $base->sendError('No Patient Found');
            }
        } catch (\Exception $e) {
            return $base->sendError($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(patient $patient)
    {
        $base = new BaseController();
        $patient->delete();
        return $base->sendResponse([], 'Patient deleted successfully');
    }
}
