<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDischargeFormRequest;
use App\Http\Requests\UpdateDischargeFormRequest;
use App\Models\DischargeForm;
use App\Models\patient;

class DischargeFormController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($patient_id)
    {
        $form = DischargeForm::first();
        $patient = patient::FindOrFail($patient_id);
        $form->template = json_decode($form->template, true);
        $sections = $form->template;
        foreach ($sections as $key => $section) {
            if (!empty($sections[$key]['content'])) {
                $sections[$key]['content'] = str_replace('[Patient Name]', $patient->first_name, $sections[$key]['content']);
            }
        }
        $form->template = $sections;
        return response()->json([
            'status' => 'success',
            'data' => $form
        ]);
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
    public function store(StoreDischargeFormRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(DischargeForm $dischargeForm)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DischargeForm $dischargeForm)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDischargeFormRequest $request, DischargeForm $dischargeForm)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DischargeForm $dischargeForm)
    {
        //
    }
}
