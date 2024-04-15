<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController as BaseController;
use App\Http\Requests\ContactRequest;
use App\Models\Contact;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Log;

class ContactController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index($patient_id)
    {
        $contact = Contact::where('patient_id', $patient_id)->orderBy('created_at', 'DESC')->get();
        $base = new BaseController();
        if (count($contact) > 0) {
            return $base->sendResponse($contact, 'Contact Data');
        } else {
            $contact = NULL;
            return $base->sendError('No Record Found');
        }
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
    public function store(ContactRequest $request)
    {
        $validatedData = $request->validated();
        $base = new BaseController();
        try {
            $validatedData['provider_id'] = auth()->user()->id;
            $validatedData['patient_id'] = $request->patient_id;
            $insurance = Contact::create($validatedData);
            return $base->sendResponse($insurance, 'Contact created successfully');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            $contact = [];
            return $base->sendError($contact, 'Internal Server Error');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Contact $contact)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Contact $contact)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $request->validate([
            'type' => 'required',
            'first_name' => 'required',
            'middle_name' => 'required',
            'relationship' => 'required',
        ]);
        $base = new BaseController();
        try {
            $contact = Contact::find($request->id);
            if ($contact) {
                $contact->update($request->all());
                return $base->sendResponse($contact, 'Contact updated successfully');
            } else {
                return $base->sendError(null, 'No Record Found');
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return $base->sendError(null, 'Internal Server Error');
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contact $contact)
    {
        $base = new BaseController();
        $contact->delete();
        return $base->sendResponse([], 'Contact deleted successfully');
    }
}
