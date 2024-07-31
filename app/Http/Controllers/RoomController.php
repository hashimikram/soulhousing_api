<?php

namespace App\Http\Controllers;

use App\Models\room;
use Illuminate\Http\Request;

class RoomController extends Controller
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
            'floor_id' => 'required|exists:floors,id',
            'room_title' => 'required',
        ]);
        try {
            $room = new room();
            $room->floor_id = $request->floor_id;
            $room->room_name = $request->room_title;
            $room->save();
            return response()->json([
                'success' => true,
                'message' => 'Room Added Successfully'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(room $room)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(room $room)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'room_title' => 'required',
        ]);
        try {
            $room = room::FindOrFail($request->room_id);
            if (isset($room)) {
                $room->room_name = $request->room_title;
                $room->save();
                return response()->json([
                    'success' => true,
                    'message' => 'Room Title Updated Successfully'
                ], 200);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Data Not Found'
                ], 404);
            }

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete_room($room_id)
    {
        $room = room::FindOrFail($room_id);
        $room->delete();
        return response()->json([
            'success' => true,
            'message' => 'Room Deleted'
        ], 200);
    }
}
