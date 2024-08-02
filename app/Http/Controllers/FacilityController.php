<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFacilityRequest;
use App\Http\Requests\UpdateFacilityRequest;
use App\Models\Facility;

class FacilityController extends Controller
{
    public function index()
    {
        $facility = Facility::orderBy('created_at', 'DESC')->get();
        return view('backend.pages.Facility.index')->with(compact('facility'));
    }

    public function all_facilities()
    {
        $facility = Facility::select('address')->get();
        return response()->json([
            'success' => true,
            'data' => $facility
        ], 200);
    }

    public function store(StoreFacilityRequest $request)
    {
        Unauthorized();
        $facility = new Facility();
        $facility->name = $request->name;
        $facility->address = $request->address;
        $facility->contact_information = $request->contact_information;
        $facility->facility_type = $request->facility_type;
        $facility->facility_capacity = $request->facility_capacity;
        $facility->save();
        return redirect()->route('facility.index')->with('success', 'Facility Added');
    }

    public function destroy($id)
    {
        check_id($id);
        $facility = Facility::FindOrFail($id);
        if (isset($facility)) {
            $facility->delete();
            return redirect()->route('facility.index')->with('success', 'Facility Deleted');
        } else {
            return redirect()->route('facility.index')->with('error', 'Data Not Found');
        }
    }

    public function edit($id)
    {
        check_id($id);
        $facility = Facility::all();
        $facilityEdit = Facility::FindOrFail($id);
        if (!isset($facilityEdit)) {
            return redirect()->route('facility.index')->with('error', 'Data Not Found');
        }
        return view('admin.pages.facility.edit')->with(compact('facility', 'facilityEdit'));
    }

    public function update(UpdateFacilityRequest $request, $id)
    {
        check_id($id);
        $facilityEdit = Facility::FindOrFail($id);
        if (!isset($facilityEdit)) {
            return redirect()->route('facility.index')->with('error', 'Data Not Found');
        } else {
            $facilityEdit->name = $request->name;
            $facilityEdit->address = $request->address;
            $facilityEdit->contact_information = $request->contact_information;
            $facilityEdit->facility_type = $request->facility_type;
            $facilityEdit->facility_capacity = $request->facility_capacity;
            $facilityEdit->save();
            return redirect()->route('facility.index')->with('success', 'Facility Updated');
        }
    }
}
