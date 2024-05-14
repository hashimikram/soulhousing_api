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
        $totalBedsCount = 0;
        $vacantBedsCount = 0;
        $pendingBedsCount = 0;

        $data = []; // Initialize the data array

        $floors = Floor::where('provider_id', auth()->user()->id)->get();

        foreach ($floors as $floor) {
            $totalBedsCount = 0;
            $occupiedBedsCount = 0;
            $pendingBedsCount = 0; // Initialize pending beds count inside the loop
            foreach ($floor->rooms as $room) {
                $totalBedsCount += count($room->beds);
                foreach ($room->beds as $bed) {
                    if ($bed->status === 'occupied') {
                        $occupiedBedsCount++;
                    } elseif ($bed->status === 'pending') {
                        $pendingBedsCount++;
                    } elseif ($bed->status === 'vacant') {
                        $vacantBedsCount++;
                    }
                }
            }

            // Add floor data directly to the $data array
            $data[] = [
                'id' => $floor->id,
                'facility_id' => $floor->facility_id,
                'provider_id' => $floor->provider_id,
                'floor_name' => $floor->floor_name,
                'created_at' => $floor->created_at,
                'updated_at' => $floor->updated_at,
                'total_beds_count' => $totalBedsCount,
                'occupied_beds_count' => $occupiedBedsCount + $pendingBedsCount,
                'vacant_beds_count' => $vacantBedsCount,
            ];
        }

        $base = new BaseController();
        if (count($data) > 0) {
            // Return the data directly without the 'data' key
            return $base->sendResponse($data, 'Floors Data');
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
                    $bedData = [
                        'id' => $bed->id,
                        'status' => $bed->status,
                        'bed_no' => $bed->bed_no,
                        'room_id' => $bed->room_id,
                        'patient_id' => $bed->patient_id,
                        'occupied_from' => $bed->occupied_from,
                        'patient' => $bed->patient ? [
                            'id' => $bed->patient->id,
                            'first_name' => $bed->patient->first_name,
                            'last_name' => $bed->patient->last_name,
                            'gender' => $bed->patient->gender,
                            'date_of_birth' => $bed->patient->date_of_birth,
                            'mrn_no' => $bed->patient->mrn_no,
                        ] : null,
                    ];


                    $roomData['beds'][] = $bedData;
                }



                $response['floor']['rooms'][] = $roomData;
            }

            // Set the beds_info after iterating through all rooms

            return $base->sendResponse($response, 'Beds with associated rooms mapped successfully');
        } catch (\Exception $e) {
            return $base->sendError('Error', $e->getMessage());
        } catch (\Exception $e) {
            return $base->sendError('Error', $e->getMessage());
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
                            'status' => 'vacant',
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




    public function update_room(Request $request)
    {
        $validatedData = $request->validate([
            'floor_id' => 'required|exists:floors,id',
            'room_name' => 'nullable|string',
        ]);
        try {
            $room = Room::create([
                'floor_id' => $request->floor_id,
                'room_name' => $request->room_title
            ]);
            return response()->json([
                'success' => true,
                'message' => 'Room Added In Floor',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function update_bed(Request $request)
    {
        $validatedData = $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'comments' => 'nullable|string',
            'booked_at' => 'nullable|date',
        ]);
        try {
            $lastBedNumber = Bed::where('room_id', $validatedData['room_id'])->max('bed_no');
            if ($lastBedNumber == NULL) {
                $bedNumber = 1;
            } else {
                $bedNumber = $lastBedNumber + 1;
            }

            Bed::create([
                'bed_no' => $bedNumber,
                'room_id' => $validatedData['room_id'],
                'comments' => $validatedData['comments'] ?? null,
                'status' => 'vacant', // assuming this is a default status
            ]);
            // $floorId = isset($data['floor_id']) ? $data['floor_id'] : null;
            // $roomTitle = isset($data['room_title']) ? $data['room_title'] : null;

            // // Check if beds data is present
            // if (isset($data['beds']) && is_array($data['beds'])) {
            //     foreach ($data['beds'] as $bedData) {
            //         // Check if comments, occupied_at, and booked_at are present
            //         if (!isset($bedData['comments'], $bedData['occupied_at'], $bedData['booked_at'])) {
            //             continue; // Skip this iteration if required bed data is missing
            //         }

            //         // If floor_id and room_title are not present, create a bed without a room
            //         if (!$floorId || !$roomTitle) {
            //             $lastBedNumber = Bed::where('room_id', $bedData['room_id'])->max('bed_no');
            //             // Start bed number from the next number after the last saved bed number
            //             $bedNumber = $lastBedNumber + 1;
            //             Bed::create([
            //                 'bed_no' => $bedNumber,
            //                 'room_id' => $bedData['room_id'],
            //                 'comments' => $bedData['comments'],
            //                 'booked_at' => $bedData['booked_at'],
            //                 'status' => 'vacant', // assuming this is a default status
            //             ]);
            //         } else {
            //             // If floor_id and room_title are present, create the room and beds
            //             $floor = Floor::findOrFail($floorId);
            //             if ($floor) {
            //                 $room = Room::create([
            //                     'floor_id' => $floorId,
            //                     'room_name' => $roomTitle
            //                 ]);
            //                 $lastBedNumber = Bed::where('room_id', $bedData['room_id'])->max('bed_no');
            //                 // Start bed number from the next number after the last saved bed number
            //                 $bedNumber = $lastBedNumber + 1;
            //                 Bed::create([
            //                     'bed_no' => $bedNumber,
            //                     'room_id' => $bedData['room_id'],
            //                     'comments' => $bedData['comments'],
            //                     'booked_at' => $bedData['booked_at'],
            //                     'status' => 'vacant', // assuming this is a default status
            //                 ]);
            //             }
            //         }
            //     }
            //     return response()->json(['message' => 'Beds added successfully']);
            // } elseif ($floorId && $roomTitle) {
            //     // If only floor_id and room_title are present, create the room
            //     $floor = Floor::findOrFail($floorId);
            //     if ($floor) {
            //         Room::create([
            //             'floor_id' => $floorId,
            //             'room_name' => $roomTitle
            //         ]);
            //         return response()->json(['message' => 'Room added successfully']);
            //     }
            // }


            // If no beds or room added, return an error
            return response()->json([
                'success' => true,
                'message' => 'Bed Added In Room',
            ], 200);
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
