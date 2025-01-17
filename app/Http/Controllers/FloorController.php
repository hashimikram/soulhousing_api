<?php

namespace App\Http\Controllers;

use App\Models\bed;
use App\Models\Facility;
use App\Models\floor;
use App\Models\room;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class FloorController extends Controller
{
    /**
     * Display a listing of the resource.
     */


    public function index()
    {
        // Initialize the data array
        $data = [];
        $floors = Floor::with(['rooms.beds', 'facility'])->get();
        try {
            // Eager load rooms and beds with floors to reduce the number of queries
            $floors = Floor::with(['rooms.beds', 'facility'])->get();
            Log::info('Successfully fetched floors and related data.', ['floor_count' => $floors->count()]);

            foreach ($floors as $floor) {
                // Initialize counters
                $totalBedsCount = 0;
                $occupiedBedsCount = 0;
                $pendingBedsCount = 0;
                $vacantBedsCount = 0;
                $totalRoomsCount = $floor->rooms->count();
                $roomDetails = [];

                foreach ($floor->rooms as $room) {
                    // Initialize room-specific bed details
                    $roomBedDetails = [
                        'room_name' => $room->room_name,
                        'total_beds' => $room->beds->count(),
                        'occupied_beds' => 0,
                        'pending_beds' => 0,
                        'vacant_beds' => 0,
                    ];

                    foreach ($room->beds as $bed) {
                        switch ($bed->status) {
                            case 'occupied':
                                $occupiedBedsCount++;
                                $roomBedDetails['occupied_beds']++;
                                break;
                            case 'pending':
                                $pendingBedsCount++;
                                $roomBedDetails['pending_beds']++;
                                break;
                            case 'vacant':
                                $vacantBedsCount++;
                                $roomBedDetails['vacant_beds']++;
                                break;
                        }
                    }

                    $totalBedsCount += $room->beds->count();
                    $roomDetails[] = $roomBedDetails;
                }

                // Add floor data to the $data array
                $data[] = [
                    'id' => $floor->id,
                    'facility_id' => $floor->facility_id,
                    'provider_id' => $floor->provider_id,
                    'floor_name' => $floor->floor_name,
                    'created_at' => $floor->created_at,
                    'updated_at' => $floor->updated_at,
                    'total_rooms_count' => $totalRoomsCount,
                    'total_beds_count' => $totalBedsCount,
                    'occupied_beds_count' => $occupiedBedsCount + $pendingBedsCount,
                    'vacant_beds_count' => $vacantBedsCount,
                    'room_details' => $roomDetails,
                    'facility_name' => $floor->facility->name,
                ];
            }

            Log::info('Data prepared for view.', ['total_floors' => count($data)]);

        } catch (Exception $e) {
            // Log any errors encountered during execution
            Log::error('Error fetching or processing floor data.', [
                'error_message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            // Optionally, you can return an error view or response
            return redirect()->back()->with('error', 'Failed to load floor data.');
        }

        // Return the view with the prepared data
        return view('backend.pages.Floors.index', ['data' => $data]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();

        $floors = $data['floors'] ?? [];

        foreach ($floors as $floorData) {
            $floor = Floor::create([
                'facility_id' => $request->facility_id,
                'floor_name' => $floorData['title'],
            ]);

            if (isset($floorData['rooms'])) {
                foreach ($floorData['rooms'] as $roomData) {
                    $room = Room::create([
                        'floor_id' => $floor->id,
                        'room_name' => $roomData['title'],
                    ]);

                    if (isset($roomData['beds'])) {
                        foreach ($roomData['beds'] as $bedData) {
                            bed::create([
                                'room_id' => $room->id,
                                'bed_title' => $bedData['title'],
                                'status' => 'vacant',
                                'comments' => '',
                            ]);
                        }
                    }
                }
            }
        }

        return redirect()->route('floors.index')->with('success', 'Floor Added Successfully');
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $facilities = Facility::alL();
        $providers = User::where('user_type', 'provider')->get();
        return view('backend.pages.Floors.create', compact('facilities', 'providers'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $floor = Floor::with('rooms.beds')->find($id); // Fetch a single floor
        if (!$floor) {
            // Handle the case when no floor is found
            return redirect()->route('floors.index')->with('error', 'Floor not found');
        }

        $providers = User::where('user_type', 'provider')->get();
        $facilities = Facility::all();

        return view('backend.pages.Floors.edit', compact('floor', 'providers', 'facilities'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $data = $request->all();

        $newRoomIds = [];

        if (isset($data['floors'])) {
            foreach ($data['floors'] as $floorId => $floorData) {
                $floor = Floor::find($floorId);
                if ($floor) {
                    $floor->floor_name = $floorData['title'];
                    $floor->save();
                }
            }
        }

        if (isset($data['rooms'])) {
            foreach ($data['rooms'] as $roomId => $roomData) {
                Log::info($roomId);
                if (strpos($roomId, 'new_') === 0) {
                    $room = new Room();
                    $room->room_name = $roomData['title'];
                    $room->floor_id = $id;
                    $room->save();
                    $newRoomIds[$roomId] = $room->id;
                } else {
                    $room = Room::find($roomId);
                    if ($room) {
                        $room->room_name = $roomData['title'];
                        $room->save();
                    }
                }
            }
        }

        if (isset($data['beds'])) {
            foreach ($data['beds'] as $bedId => $bedData) {
                if (strpos($bedId, 'new_') === 0) {
                    $bed = new Bed();
                    $bed->bed_title = $bedData['title'];
                    if (isset($bedData['room_id'])) {
                        $bed->room_id = $newRoomIds[$bedData['room_id']] ?? $bedData['room_id'];
                    }
                    $bed->save();
                } else {
                    $bed = bed::find($bedId);
                    if ($bed) {
                        $bed->bed_title = $bedData['title'];
                        $bed->save();
                    }
                }
            }
        }

        return redirect()->route('floors.index')->with('success', 'Data updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function mapping($id)
    {
        $floor = Floor::with([
            'rooms',
            'beds' => function ($query) {
                $query->select('beds.id', 'beds.status', 'beds.bed_no', 'beds.room_id', 'beds.patient_id',
                    'beds.occupied_from')
                    ->with(['patient:id,first_name,last_name,gender,date_of_birth,mrn_no']);
            }
        ])->where('floors.id', $id)->first();

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
                    ] : null,
                ];


                $roomData['beds'][] = $bedData;
            }


            $response['floor']['rooms'][] = $roomData;
        }
//        $floor = Floor::with('rooms.beds')->find($id);
        if (!$floor) {
            return redirect()->route('floors.index')->with('error', 'Floor not found');
        }

        return view('backend.pages.Floors.mapping', compact('response'));
    }

    public function assign_bed(Request $request)
    {
        $request->validate([
            'bed_id' => 'required|exists:beds,id',
            'patient_id' => 'required|exists:patients,id',
        ]);

        $beds = bed::where('id', $request->bed_id)->first();
        if ($beds != null) {
            try {
                $checkAssignBed = bed::where(['patient_id' => $request->patient_id])->first();
                if (isset($checkAssignBed)) {
                    return response()->json([
                        'code' => false,
                        'status' => '1',
                        'old_bed_id' => $checkAssignBed->id, // Return the old bed id
                        'message' => 'Patient already assigned',
                    ], 200);
                } else {
                    $occupied_at = date('Y-m-d h:i:s', strtotime($request->occupied_at));
                    $booked_till = date('Y-m-d h:i:s', strtotime($request->booked_till));
                    $beds->patient_id = $request->patient_id;
                    $beds->occupied_from = $occupied_at;
                    $beds->booked_till = $booked_till;
                    $beds->status = 'occupied';
                    $beds->save();
                    return response()->json([
                        'code' => true,
                        'message' => 'Patient added',
                    ], 200);
                }
            } catch (Exception $e) {
                return response()->json([
                    'code' => false,
                    'message' => $e->getMessage(),
                ], 200);
            }
        } else {
            return response()->json([
                'code' => false,
                'message' => 'Bed not found',
            ], 404);
        }
    }

    public function transfer_patient(Request $request)
    {
        $request->validate([
            'old_bed_id' => 'required|exists:beds,id',
            'new_bed_id' => 'required|exists:beds,id',
            'patient_id' => 'required|exists:patients,id',
        ]);

        $oldBed = bed::where('id', $request->old_bed_id)->first();
        $newBed = bed::where('id', $request->new_bed_id)->first();

        if ($oldBed && $newBed) {
            try {
                $oldBed->patient_id = null;
                $oldBed->status = 'vacant';
                $oldBed->occupied_from = null;
                $oldBed->booked_till = null;
                $oldBed->save();

                $newBed->patient_id = $request->patient_id;
                $newBed->status = 'occupied';
                $newBed->save();

                return response()->json([
                    'code' => true,
                    'message' => 'Patient transferred successfully',
                ], 200);
            } catch (Exception $e) {
                return response()->json([
                    'code' => false,
                    'message' => $e->getMessage(),
                ], 500);
            }
        } else {
            return response()->json([
                'code' => false,
                'message' => 'Bed not found',
            ], 404);
        }
    }
}
