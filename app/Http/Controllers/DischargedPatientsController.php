<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDischargedPatientsRequest;
use App\Http\Requests\UpdateDischargedPatientsRequest;
use App\Models\AdmissionDischarge;
use App\Models\DischargedPatients;
use PDF;

class DischargedPatientsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDischargedPatientsRequest $request)
    {
        $dischargedPatient = DischargedPatients::create([
            'provider_id' => $request->input('provider_id'),
            'patient_id' => $request->input('patient_id'),
            'admission_id' => $request->input('admission_id'),
            'date_of_discharge' => $request->input('date_of_discharge'),
            'acknowledgment_of_discharge' => $request->input('formData')['acknowledgment-of-discharge'] ?? null,
            'release_of_liability' => $request->input('formData')['release-of-liability'] ?? null,
            'acknowledgment_of_receipt_of_belongings_and_medication' => $request->input('formData')['acknowledgment-of-receipt-of-belongings-and-medication'] ?? null,
            'belongings' => $request->input('formData')['belongings'] ?? null,
            'medications' => $request->input('formData')['medications'] ?? null,
            'patient_signature' => $request->input('formData')['patient-signature'] ?? null,
            'staff_witness_signature' => $request->input('formData')['staff-witness-signature'] ?? null,
            'patient_signature_date' => $request->input('patient_signature_date'),
            'staff_signature_date' => $request->input('staff_signature_date'),
        ]);


        $admission = AdmissionDischarge::findOrfail($request->input('admission_id'));
        if ($admission) {
            $admission->status = '0';
            $admission->save();
//            $patient = $admission->patient;
//            $user = $admission->staff;
//            $dischargeForm = $dischargedPatient->toArray();
//            $data = [
//                'admission' => $admission,
//                'patient' => $patient,
//                'user' => $user,
//                'dischargeForm' => $dischargeForm,
//            ];
//            $pdf = PDF::loadView('PDF.patient_discharge_pdf', $data);
        }


        // Return a response
        return response()->json([
            'message' => 'Discharged patient record created successfully.',
            'data' => $dischargedPatient,
        ], 201);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(DischargedPatients $dischargedPatients)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DischargedPatients $dischargedPatients)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDischargedPatientsRequest $request, DischargedPatients $dischargedPatients)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DischargedPatients $dischargedPatients)
    {
        //
    }
}
