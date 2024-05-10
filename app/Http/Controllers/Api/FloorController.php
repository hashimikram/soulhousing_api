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
    public function mapBedRooms($floor_id)
    {
        $base = new BaseController();
        try {
            $floor = Floor::with([
                'rooms',
                'beds' => function ($query) {
                    $query->select('beds.id', 'beds.status', 'beds.bed_no', 'beds.room_id', 'beds.patient_id', 'beds.occupied_from')
                        ->with(['patient:id,first_name,last_name,gender,date_of_birth,mrn_no']);
                }
            ])->where('floors.id', $floor_id)->first();
dd($floor);
            $response = [
                'floor' => [
                    'id' => $floor->id,
                    'facility_id' => $floor->facility_id,
                    'provider_id' => $floor->provider_id,
                    'floor_name' => $floor->floor_name,
                    'created_at' => $floor->created_at,
                    'updated_at' => $floor->updated_at,
                    'rooms' => [],
                ],
                'floor_id' => $floor->id,
            ];

            foreach ($floor->rooms as $room) {
                $roomData = [
                    'id' => $room->id,
                    'floor_id' => $room->floor_id,
                    'room_name' => $room->room_name,
                    'created_at' => $room->created_at,
                    'updated_at' => $room->updated_at,
                    'beds' => [],
                ];

                foreach ($room->beds as $bed) {
                    $patient = $bed->patient;
                    $roomData['beds'][] = [
                        'id' => $bed->id,
                        'status' => $bed->status,
                        'bed_no' => $bed->bed_no,
                        'room_id' => $bed->room_id,
                        'patient_id' => $bed->patient_id,
                        'occupied_from' => $bed->occupied_from,
                        'patient' => [
                            'id' => $patient->id,
                            'first_name' => $patient->first_name,
                            'last_name' => $patient->last_name,
                            'gender' => $patient->gender,
                            'date_of_birth' => $patient->date_of_birth,
                            'mrn_no' => $patient->mrn_no,
                        ],
                    ];
                }

                $response['floor']['rooms'][] = $roomData;
            }

            return $base->sendResponse($response, 'Beds with associated rooms mapped successfully');
        } catch (\Exception $e) {
            // Handle the exception
            return $base->sendError('Error', $e->getMessage());
        }
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
                            'status' => 'vacand',
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

    public function update_one(Request $request)
    {
        $data = $request->json()->all();
        try {
            if (isset($data['floor_id']) || isset($data['room_title'])) {
                $floorId = $data['floor_id'];
                $roomTitle = $data['room_title'];

                $floor = Floor::findOrFail($floorId);
                if (isset($floor)) {
                    // Create the room
                    $room = Room::create([
                        'floor_id' => $floorId,
                        'room_name' => $roomTitle
                    ]);
                } else {
                    return response()->json(['message' => 'Floor Not Found']);
                }
            }


            // Check if beds data is present
            if (isset($data['beds']) && is_array($data['beds'])) {
                foreach ($data['beds'] as $bedData) {
                    // Check if comments, occupied_at, and booked_at are present
                    if (!isset($bedData['comments'], $bedData['occupied_at'], $bedData['booked_at'])) {
                        continue; // Skip this iteration if required bed data is missing
                    }
                    $lastBedNumber = Bed::where('room_id', $bedData['room_id'])->max('bed_no');
                    // Start bed number from the next number after the last saved bed number
                    $bedNumber = $lastBedNumber + 1;
                    Bed::create([
                        'room_id' => $bedData['room_id'],
                        'bed_no' => $bedNumber,
                        'comments' => $bedData['comments'],
                        'occupied_at' => $bedData['occupied_at'],
                        'booked_at' => $bedData['booked_at'],
                        'status' => 'vacant', // assuming this is a default status
                    ]);
                }
            }

            return response()->json(['message' => 'Room and Beds created successfully']);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }


    public function update(Request $request)
    {
        $data = $request->json()->all();
        try {
            $floorId = isset($data['floor_id']) ? $data['floor_id'] : null;
            $roomTitle = isset($data['room_title']) ? $data['room_title'] : null;

            // Check if beds data is present
            if (isset($data['beds']) && is_array($data['beds'])) {
                foreach ($data['beds'] as $bedData) {
                    // Check if comments, occupied_at, and booked_at are present
                    if (!isset($bedData['comments'], $bedData['occupied_at'], $bedData['booked_at'])) {
                        continue; // Skip this iteration if required bed data is missing
                    }

                    // If floor_id and room_title are not present, create a bed without a room
                    if (!$floorId || !$roomTitle) {
                        $lastBedNumber = Bed::where('room_id', $bedData['room_id'])->max('bed_no');
                        // Start bed number from the next number after the last saved bed number
                        $bedNumber = $lastBedNumber + 1;
                        Bed::create([
                            'bed_no' => $bedNumber,
                            'room_id' => $bedData['room_id'],
                            'comments' => $bedData['comments'],
                            'booked_at' => $bedData['booked_at'],
                            'status' => 'vacant', // assuming this is a default status
                        ]);
                    } else {
                        // If floor_id and room_title are present, create the room and beds
                        $floor = Floor::findOrFail($floorId);
                        if ($floor) {
                            $room = Room::create([
                                'floor_id' => $floorId,
                                'room_name' => $roomTitle
                            ]);
                            $lastBedNumber = Bed::where('room_id', $bedData['room_id'])->max('bed_no');
                            // Start bed number from the next number after the last saved bed number
                            $bedNumber = $lastBedNumber + 1;
                            Bed::create([
                                'bed_no' => $bedNumber,
                                'room_id' => $bedData['room_id'],
                                'comments' => $bedData['comments'],
                                'booked_at' => $bedData['booked_at'],
                                'status' => 'vacant', // assuming this is a default status
                            ]);
                        }
                    }
                }
                return response()->json(['message' => 'Beds added successfully']);
            } elseif ($floorId && $roomTitle) {
                // If only floor_id and room_title are present, create the room
                $floor = Floor::findOrFail($floorId);
                if ($floor) {
                    Room::create([
                        'floor_id' => $floorId,
                        'room_name' => $roomTitle
                    ]);
                    return response()->json(['message' => 'Room added successfully']);
                }
            }

            // If no beds or room added, return an error
            return response()->json(['error' => 'Invalid JSON payload. No beds or room added.'], 400);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(floor $floor)
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
