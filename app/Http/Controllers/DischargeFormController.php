<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDischargeFormRequest;
use App\Http\Requests\UpdateDischargeFormRequest;
use App\Models\DischargeForm;

class DischargeFormController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $form = DischargeForm::first();
        $form->template = json_decode($form->template);
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
