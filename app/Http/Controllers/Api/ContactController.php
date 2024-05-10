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
    public function store(Request $request)
    {

        $request->validate([
            'type' => 'required',
            'first_name' => 'required',
            'middle_name' => 'required',
            'relationship' => 'required',


        ]);

        $base = new BaseController();
        try {
            $contact = new Contact();
            $contact->patient_id = $request->patient_id;
            $contact->provider_id = auth()->user()->id;
            $contact->type = $request->type;
            $contact->title = $request->title;
            $contact->first_name = $request->first_name;
            $contact->middle_name = $request->middle_name;
            $contact->date_of_birth = $request->date_of_birth;
            $contact->relationship = $request->relationship;
            $contact->email = $request->email;
            $contact->address = $request->address;
            $contact->city = $request->city;
            $contact->state = $request->state;
            $contact->zip_code = $request->zip_code;
            $contact->country = $request->country;
            $contact->home_phone = $request->home_phone;
            $contact->work_phone = $request->work_phone;
            $contact->mobile_number = $request->mobile_number;
            $contact->fax = $request->fax;
            $contact->method_of_contact = $request->method_of_contact;
            $contact->support_contact = $request->support_contact;
            $contact->from_date = $request->from_date;
            $contact->to_date = $request->to_date;
            $contact->status = $request->status;
            $contact->indefinitely = $request->indefinitely;
            $contact->power_of_attorney = $request->power_of_attorney;
            $contact->from_date2 = $request->from_date2;
            $contact->to_date2 = $request->to_date2;
            $contact->status2 = $request->status2;
            $contact->indefinitely2 = $request->indefinitely2;
            $contact->power_of_attorney2 = $request->power_of_attorney2;
            $contact->from_date3 = $request->from_date3;
            $contact->to_date3 = $request->to_date3;
            $contact->status3 = $request->status3;
            $contact->indefinitely3 = $request->indefinitely3;
            $contact->save();
            return $base->sendResponse($contact, 'Contact created successfully');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            $contact = [];
            return $base->sendError($contact, $e->getMessage());
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
