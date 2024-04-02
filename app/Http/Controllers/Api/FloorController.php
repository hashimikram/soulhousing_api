<?php

namespace App\Http\Controllers;

use App\Models\floor;
use Illuminate\Http\Request;

class FloorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
            'number_of_floors' => 'required|integer|min:1',
            'number_of_rooms' => 'required|array',
            'number_of_rooms.*' => 'required|integer|min:1',
            'number_of_beds' => 'required|array',
            'number_of_beds.*.*' => 'required|integer|min:1',
        ]);

        $numberOfFloors = $request->number_of_floors;
        $numberOfRooms = $request->number_of_rooms;
        $numberOfBeds = $request->number_of_beds;

        // Loop through each floor
        for ($floorIndex = 0; $floorIndex < $numberOfFloors; $floorIndex++) {
            $floor = Floor::create(['number' => $floorIndex + 1]);

            // Loop through each room for the current floor
            for ($roomIndex = 0; $roomIndex < $numberOfRooms[$floorIndex]; $roomIndex++) {
                $room = Room::create(['floor_id' => $floor->id, 'number' => $roomIndex + 1]);

                // Loop through each bed for the current room
                for ($bedIndex = 0; $bedIndex < $numberOfBeds[$floorIndex][$roomIndex]; $bedIndex++) {
                    Bed::create(['room_id' => $room->id, 'number' => $bedIndex + 1]);
                }
            }
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
