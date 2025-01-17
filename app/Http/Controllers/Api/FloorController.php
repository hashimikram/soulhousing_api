<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController as BaseController;
use App\Models\bed;
use App\Models\floor;
use App\Models\room;
use Exception;
use Illuminate\Http\Request;

class FloorController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = []; // Initialize the data array
        if (auth()->user()->user_type == 'admin') {
            $floors = Floor::all();
        } else {
            $floors = Floor::where('facility_id', current_facility(auth()->user()->id))->get();
        }

        $totalFloorsCount = 0;
        $totalRoomsCount = 0;
        $totalBedsCount = 0;
        $occupiedBedsCount = 0;
        $vacantBedsCount = 0;
        $unpreparedBedsCount = 0;
        $pendingBedsCount = 0;
        $facilityName = null; // Initialize facility name

        // Iterate through each floor
        foreach ($floors as $floor) {
            $totalFloorsCount++; // Increment total floors count

            $floorTotalRoomsCount = $floor->rooms->count(); // Count total rooms for each floor
            $totalRoomsCount += $floorTotalRoomsCount; // Add to total rooms count

            $floorTotalBedsCount = 0;
            $floorOccupiedBedsCount = 0;
            $floorVacantBedsCount = 0;
            $floorUnpreparedBedsCount = 0;
            $floorPendingBedsCount = 0;

            foreach ($floor->rooms as $room) {
                $floorTotalBedsCount += $room->beds->count(); // Count total beds for each room

                foreach ($room->beds as $bed) {
                    if ($bed->status == 'occupied') {
                        $floorOccupiedBedsCount++;
                    } elseif ($bed->status == 'vacant') {
                        $floorVacantBedsCount++;
                    } elseif ($bed->status == 'unprepared') {
                        $floorUnpreparedBedsCount++;
                    } elseif ($bed->status == 'pending') {
                        $floorPendingBedsCount++;
                    }
                }
            }

            $totalBedsCount += $floorTotalBedsCount; // Add to total beds count
            $occupiedBedsCount += $floorOccupiedBedsCount;
            $vacantBedsCount += $floorVacantBedsCount;
            $pendingBedsCount += $floorPendingBedsCount;
            $unpreparedBedsCount += $floorUnpreparedBedsCount;

            // Set the facility name (assuming all floors belong to the same facility)
            if (!$facilityName) {
                $facilityName = $floor->facility->name ?? null;
            }

            // Add floor data to the $data array
            $data[] = [
                'id' => $floor->id,
                'facility_id' => $floor->facility_id,
                'provider_id' => $floor->provider_id,
                'floor_name' => $floor->floor_name,
                'created_at' => $floor->created_at,
                'updated_at' => $floor->updated_at,
                'total_rooms_count' => $floorTotalRoomsCount,
                'total_beds_count' => $floorTotalBedsCount,
                'occupied_beds_count' => $floorOccupiedBedsCount,
                'vacant_beds_count' => $floorVacantBedsCount,
            ];
        }

        // Add totals to the response
        $totals = [
            'total_floors_count' => $totalFloorsCount,
            'total_rooms_count' => $totalRoomsCount,
            'total_beds_count' => $totalBedsCount,
            'occupied_beds_count' => $occupiedBedsCount,
            'vacant_beds_count' => $vacantBedsCount,
            'pending_beds_count' => $pendingBedsCount,
            'unprepared_beds_count' => $unpreparedBedsCount,
            'facility_name' => $facilityName, // Add facility name to totals
        ];

        // Prepare final response structure
        $response = [
            'success' => true,
            'data' => $data, // Floors data
            'totals' => $totals, // Overall totals
            'message' => 'Floors Data',
        ];

        $base = new BaseController();
        if (count($response) > 0) {
            if (request()->expectsJson()) {
                // Return the data directly as JSON
                return response()->json($response);
            } else {
                // Return the view with data
                return view('backend.pages.Floors.index', ['data' => $data, 'totals' => $totals]);
            }
        } else {
            if (request()->expectsJson()) {
                return $base->sendError('No Data Found');
            } else {
                // Return the view for no data
                return view('backend.pages.Floors.index', ['data' => $data, 'totals' => $totals]);
            }
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
            return $base->sendResponse($response,
                'There are Total ' . $rooms . ' Rooms and Total ' . $beds . ' Beds in ' . $floor->id . ' Floor');
        } catch (Exception $e) {
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
                    $query->select('beds.id', 'beds.status', 'beds.bed_no', 'beds.room_id', 'beds.patient_id',
                        'beds.occupied_from')
                        ->with(['patient:id,first_name,last_name,gender,date_of_birth,mrn_no']);
                }
            ])->where('floors.id', $floor_id)->first();

            // Initialize counters
            $totalRooms = 0;
            $totalBeds = 0;
            $totalVacantBeds = 0;
            $totalOccupiedBeds = 0;
            $totalPendingBeds = 0;
            $totalUnPreparedBeds = 0;

            $currentFloorRooms = 0;
            $currentFloorBeds = 0;
            $currentFloorVacantBeds = 0;
            $currentFloorOccupiedBeds = 0;
            $currentFloorPendingBeds = 0;
            $currentFloorUnPreparedBeds = 0;

            $response = [
                'floor' => [
                    'id' => $floor->id,
                    'facility_id' => $floor->facility_id,
                    'facility_name' => $floor->facility->name,
                    'provider_id' => $floor->provider_id,
                    'floor_name' => $floor->floor_name,
                    'created_at' => $floor->created_at,
                    'updated_at' => $floor->updated_at,
                    'rooms' => [],
                ],
                'floor_id' => $floor->id,
            ];

            foreach ($floor->rooms as $room) {
                $currentFloorRooms++; // Increment current floor rooms count

                $roomData = [
                    'id' => $room->id,
                    'floor_id' => $room->floor_id,
                    'room_name' => $room->room_name,
                    'created_at' => $room->created_at,
                    'updated_at' => $room->updated_at,
                    'beds' => [],
                ];

                foreach ($room->beds as $bed) {
                    $totalBeds++;
                    $currentFloorBeds++; // Increment current floor beds count

                    // Count beds by status
                    switch ($bed->status) {
                        case 'vacant':
                            $totalVacantBeds++;
                            $currentFloorVacantBeds++; // Increment current floor vacant beds count
                            break;
                        case 'occupied':
                            $totalOccupiedBeds++;
                            $currentFloorOccupiedBeds++; // Increment current floor occupied beds count
                            break;
                        case 'pending':
                            $totalPendingBeds++;
                            $currentFloorPendingBeds++; // Increment current floor pending beds count
                            break;
                        case 'unprepared':
                            $totalUnPreparedBeds++;
                            $currentFloorUnPreparedBeds++; // Increment current floor unprepared beds count
                            break;
                    }

                    $bedData = [
                        'id' => $bed->id,
                        'status' => $bed->status,
                        'bed_no' => $bed->bed_no,
                        'bed_title' => $bed->bed_title ?? null,
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
                            'medical_no' => $bed->patient->medical_no,
                            'medical_dependency' => $bed->patient->medical_dependency,
                        ] : [],
                    ];

                    $roomData['beds'][] = $bedData;
                }

                $response['floor']['rooms'][] = $roomData;
            }

            // Add the totals to the response
            $response['total_rooms'] = $totalRooms;
            $response['total_beds'] = $totalBeds;
            $response['total_vacant_beds'] = $totalVacantBeds;
            $response['total_occupied_beds'] = $totalOccupiedBeds;
            $response['total_pending_beds'] = $totalPendingBeds;
            $response['total_unprepared_beds'] = $totalUnPreparedBeds;

            // Add the current floor totals to the response
            $response['floor']['total_rooms_current_floor'] = $currentFloorRooms;
            $response['floor']['total_beds_current_floor'] = $currentFloorBeds;
            $response['floor']['total_vacant_beds_current_floor'] = $currentFloorVacantBeds;
            $response['floor']['total_occupied_beds_current_floor'] = $currentFloorOccupiedBeds;
            $response['floor']['total_pending_beds_current_floor'] = $currentFloorPendingBeds;
            $response['floor']['total_unprepared_beds_current_floor'] = $currentFloorUnPreparedBeds;

            return $base->sendResponse($response, 'Beds with associated rooms mapped successfully');
        } catch (Exception $e) {
            return $base->sendError('Error', $e->getMessage());
        }
    }


    public function all_floors_by_status($status)
    {
        if ($status == '0') {
            return response()->json([
                'code' => 'success',
                'data' => [],
            ]);
        } else {
            $status = 'vacant';
            $base = new BaseController();
            try {
                $floors = floor::where('facility_id', current_facility(auth()->user()->id))->get();
                $response = []; // Initialize the response array here

                foreach ($floors as $details) {
                    $rooms = Room::where('floor_id', $details->id)->with([
                        'beds' => function ($query) use ($status) {
                            $query->where('status', $status)->select('beds.id', 'beds.status', 'beds.bed_no',
                                'beds.room_id', 'beds.patient_id', 'beds.occupied_from')
                                ->with(['patient:id,first_name,last_name,gender,date_of_birth,mrn_no']);
                        }
                    ])->get();

                    foreach ($rooms as $room) {
                        $floor = floor::where('id', $room->floor_id)->first();
                        foreach ($room->beds as $bed) {
                            if ($bed->status == 'vacant') {
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
                                    'floor_name' => $floor->floor_name,
                                    'room_name' => $room->room_name,
                                    'created_at' => $room->created_at,
                                    'updated_at' => $room->updated_at,
                                ];

                                $response[] = $bedData;
                            }
                        }
                    }
                }

                return $base->sendResponse($response, 'Beds with status "' . $status . '" retrieved successfully');
            } catch (Exception $e) {
                return $base->sendError('Error', $e->getMessage());
            }
        }
    }

    public function get_unprepared_beds($status)
    {
        $status = 'unprepared';
        $base = new BaseController();
        try {
            $floors = floor::where('facility_id', current_facility(auth()->user()->id))->get();
            $response = []; // Initialize the response array here
            foreach ($floors as $details) {
                $rooms = Room::where('floor_id', $details->id)->with([
                    'beds' => function ($query) use ($status) {
                        $query->where('status', $status)->select('beds.id', 'beds.status', 'beds.bed_no',
                            'beds.room_id', 'beds.patient_id', 'beds.occupied_from')
                            ->with(['patient:id,first_name,last_name,gender,date_of_birth,mrn_no']);
                    }
                ])->get();

                foreach ($rooms as $room) {
                    $floor = floor::where('id', $room->floor_id)->first();
                    foreach ($room->beds as $bed) {
                        if ($bed->status == 'unprepared') {
                            $bedData = [
                                'id' => $bed->id,
                                'status' => $bed->status,
                                'bed_no' => $bed->bed_no,
                                'bed_title' => $bed->bed_title,
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
                                'floor_name' => $floor->floor_name,
                                'room_name' => $room->room_name,
                                'created_at' => $room->created_at,
                                'updated_at' => $room->updated_at,
                            ];

                            $response[] = $bedData;
                        }
                    }
                }
            }

            return $base->sendResponse($response, 'Beds with status "' . $status . '" retrieved successfully');
        } catch (Exception $e) {
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
                    'facility_id' => current_facility(auth()->user()->id),
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
                            'bed_title' => $bedData['bed_title'] ?? '',
                            'status' => 'vacant',
                        ]);
                    }
                }
            }


            return response()->json(['message' => 'Data saved successfully'], 200);
        } catch (Exception $e) {
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
        } catch (Exception $e) {
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
            'bed_title' => 'nullable',
        ]);
        try {
            $lastBedNumber = Bed::where('room_id', $validatedData['room_id'])->max('bed_no');
            if ($lastBedNumber == null) {
                $bedNumber = 1;
            } else {
                $bedNumber = $lastBedNumber + 1;
            }

            Bed::create([
                'bed_no' => $bedNumber,
                'room_id' => $validatedData['room_id'],
                'comments' => $validatedData['comments'] ?? null,
                'bed_title' => $validatedData['bed_title'] ?? null,
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
        } catch (Exception $e) {
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

    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:floors,id',
            'floor_name' => 'required|string',
        ]);
        $base = new BaseController();
        try {
            $data = request()->all();
            $floor = Floor::findOrFail($data['id']);
            $floor->update([
                'floor_name' => $data['floor_name'],
            ]);
            return $base->sendResponse($floor, 'Floor Name updated successfully');
        } catch (Exception $e) {
            return $base->sendError($e->getMessage());
        }
    }
}
