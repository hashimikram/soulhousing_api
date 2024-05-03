<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController as BaseController;
use App\Models\bed;
use App\Models\floor;
use App\Models\room;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class FloorController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $floors = floor::where('provider_id', auth()->user()->id)->get();
        $base = new BaseController();
        if (count($floors) > 0) {
            return $base->sendResponse($floors, 'Floors Data');
        } else {
            return $base->sendError('No Data Found');
        }
    }

    public function form_data(Request $request)
    {
        return $request;
    }

    public function bedsAndrooms($floor_id)
    {
        $base = new BaseController();
        try {
            $floor = Floor::with('rooms')->with('beds')->findOrFail($floor_id);
            $rooms = $floor->rooms()->count();
            $beds = $floor->beds()->count();
            // Return the response
            $response = [
                'floor' => $floor,
                'floor_id' => $floor->id,
                'rooms_count' => $rooms,
                'beds_count' => $beds,
            ];
            return $base->sendResponse($response, 'There are Total ' . $rooms . ' Rooms and Total ' . $beds . ' Beds in ' . $floor->id . ' Floor');
        } catch (\Exception $e) {
            // Handle the exception
            return $base->sendError('Error', $e->getMessage());
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
        // $request->validate([
        //     'no_of_floors' => 'required|integer',
        //     'floors' => 'required|array',
        //     'floors.*.no_of_rooms' => 'required|integer',
        //     'floors.*.Rooms' => 'required|array',
        //     'floors.*.Rooms.*.no_of_beds' => 'required|integer',
        //     'floors.*.Rooms.*.beds' => 'required|array',
        // ]);

        $base = new BaseController();
        try {
            $facilityId = rand(12345, 67890);
            $data = $request->all();

            foreach ($data as $floorData) {
                // Create a new floor
                $floor = Floor::create([
                    'provider_id' => auth()->user()->id,
                    'facility_id' => $facilityId,
                    'floor_name' => $floorData['floor_title'] ?? '',
                ]);

                $bedCounter = 0; // Reset the bed counter for each floor

                foreach ($floorData['rooms'] as $roomData) {
                    $room = Room::create([
                        'floor_id' => $floor->id,
                        'room_name' => $roomData['room_title'] ?? '',
                    ]);

                    foreach ($roomData['beds'] as $bedData) {
                        $bedCounter++; // Increment the bed counter for each bed
                        Bed::create([
                            'room_id' => $room->id,
                            'bed_no' => $bedCounter, // Set the bed number
                            'comments' => $bedData['comments'],
                            'patient_id' => $bedData['patient_id'],
                            'occupied_at' => $bedData['occupied_at'] ?? Carbon::now(),
                            'booked_till' => $bedData['booked_at'] ?? Carbon::now(),
                        ]);
                    }
                }
            }


            return response()->json(['message' => 'Data saved successfully'], 200);
        } catch (\Exception $e) {
            return $base->sendError($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(floor $floor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(floor $floor)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, floor $floor)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(floor $floor)
    {
        //
    }
}
