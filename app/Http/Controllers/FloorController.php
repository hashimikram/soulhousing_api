<?php

namespace App\Http\Controllers;

use App\Models\bed;
use App\Models\Facility;
use App\Models\floor;
use App\Models\room;
use App\Models\User;
use Illuminate\Http\Request;

class FloorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = []; // Initialize the data array
        if (auth()->user()->user_type == 'super_admin') {
            $floors = Floor::join('facilities', 'facilities.id', '=', 'floors.facility_id')->select('floors.*',
                'facilities.name')->get();
        } else {
            $floors = Floor::join('facilities', 'facilities.id', '=', 'floors.facility_id')->select('floors.*',
                'facilities.name')->where('floors.provider_id', auth()->user()->id)->get();
        }

        foreach ($floors as $floor) {
            $totalBedsCount = 0;
            $occupiedBedsCount = 0;
            $pendingBedsCount = 0;
            $vacantBedsCount = 0;
            $totalRoomsCount = $floor->rooms->count();
            $roomDetails = [];

            foreach ($floor->rooms as $room) {
                $roomBedDetails = [
                    'room_name' => $room->room_name,
                    'total_beds' => $room->beds->count(),
                    'occupied_beds' => 0,
                    'pending_beds' => 0,
                    'vacant_beds' => 0,
                ];

                foreach ($room->beds as $bed) {
                    if ($bed->status == 'occupied') {
                        $occupiedBedsCount++;
                        $roomBedDetails['occupied_beds']++;
                    } elseif ($bed->status == 'pending') {
                        $pendingBedsCount++;
                        $roomBedDetails['pending_beds']++;
                    } elseif ($bed->status == 'vacant') {
                        $vacantBedsCount++;
                        $roomBedDetails['vacant_beds']++;
                    }
                }

                $totalBedsCount += $room->beds->count();
                $roomDetails[] = $roomBedDetails;
            }

            // Add floor data directly to the $data array
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
                'room_details' => $roomDetails, // Add room details
                'facility_name' => $floor->name,
            ];
        }

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
                            Bed::create([
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
        // Fetch the floor to update
        $floor = Floor::find($id);

        // Update floor details
        $floor->update([
            'floor_name' => $request->input('floors.'.$id.'.title'),
            'facility_id' => $request->input('facility_id'),
        ]);

        // Handle rooms
        foreach ($request->input('rooms', []) as $roomId => $roomData) {
            if (is_numeric($roomId)) {
                $room = Room::find($roomId);
                if ($room) {
                    $room->update([
                        'room_name' => $roomData['title'],
                    ]);
                    // Handle beds
                    foreach ($request->input('beds', []) as $bedId => $bedData) {
                        if (isset($bedData['delete']) && $bedData['delete'] == '1') {
                            // Handle deletion for beds that have an ID
                            if (is_numeric($bedId)) {
                                Bed::destroy($bedId); // Delete bed
                            }
                        } else {
                            // Ensure room_id and title are set
                            if (!isset($bedData['room_id']) || !isset($bedData['title'])) {
                                continue; // Skip this entry if necessary data is missing
                            }

                            if (is_numeric($bedId)) {
                                // Update existing bed
                                $bed = Bed::find($bedId);
                                if ($bed) {
                                    $bed->update([
                                        'bed_title' => $bedData['title'],
                                        'room_id' => $bedData['room_id'],
                                    ]);
                                }
                            } else {
                                // Handle new beds (no ID yet)
                                Bed::create([
                                    'bed_title' => $bedData['title'],
                                    'room_id' => $bedData['room_id'],
                                    // Add other necessary fields if required
                                ]);
                            }
                        }
                    }


                }
            }
        }

        // Add new rooms and beds if necessary
        foreach ($request->input('rooms', []) as $roomId => $roomData) {
            if (!is_numeric($roomId)) {
                Room::create([
                    'room_name' => $roomData['title'],
                    'floor_id' => $id,
                ]);
            }
        }

        foreach ($request->input('beds', []) as $bedId => $bedData) {
            if (!is_numeric($bedId)) {
                Bed::create([
                    'bed_title' => $bedData['title'],
                    'room_id' => $bedData['room_id'],
                ]);
            }
        }

        return redirect()->route('floors.index')->with('success', 'Floor updated successfully.');
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

        return view('backend.pages.Floors.mapping', compact('response',));
    }
}
