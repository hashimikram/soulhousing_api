<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFacilityRequest;
use App\Http\Requests\UpdateFacilityRequest;
use App\Models\Facility;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


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

    public function LoginUserFacility()
    {
        $user = User::FindOrFail(Auth::id());
        $user_Facilities = json_decode($user->details->facilities, true);
        $transformed_Facilities = [];
        if (is_array($user_Facilities)) {
            foreach ($user_Facilities as $facility_id) {
                $facilities_table = Facility::where('id', $facility_id)->first();
                if ($facilities_table) {
                    $transformed_Facilities[] = [
                        'id' => $facilities_table->id,
                        'facility_name' => $facilities_table->name
                    ];
                }
            }
        }
        $success['user_facilities'] = $transformed_Facilities;
        return response()->json([
            'status' => 'success',
            'data' => $success,
        ], 200);
    }

    public function updateLoginUserFacility(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'facility_id' => 'required|integer|exists:facilities,id',
        ]);

        // Retrieve the authenticated user
        $user = Auth::user();

        // Update the current facility for the user's personal access token
        DB::table('personal_access_tokens')
            ->where('tokenable_id', $user->id)
            ->update(['current_facility' => $validatedData['facility_id']]);

        // Return a JSON response indicating success
        return response()->json([
            'status' => 'success',
            'message' => 'Facility updated successfully.',
        ], 200);
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
