<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreschedulingRequest;
use App\Http\Requests\UpdateschedulingRequest;
use App\Jobs\SendScheduleEmail;
use App\Models\scheduling;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SchedulingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sheduling = scheduling::where('facility_id', current_facility(auth()->user()->id))->get();
        foreach ($sheduling as $schedule) {
            $schedule->member = User::find($schedule->member_id)->name;
        }
        return response()->json([
            'status' => true,
            'message' => 'Scheduling list',
            'data' => $sheduling
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreschedulingRequest $request)
    {
        try {
            $scheduling = new scheduling();
            $scheduling->provider_id = auth()->id();
            $scheduling->member_id = $request->member_id;
            $scheduling->facility_id = current_facility(auth()->user()->id);
            $scheduling->title = $request->name;
            $scheduling->description = $request->description;
            $scheduling->time = $request->time;
            $scheduling->date = $request->date;
            $scheduling->end_time = $request->end_time;
            $scheduling->save();
            Log::info('Scheduling created successfully');
            Log::info('Sending email to member...');
            SendScheduleEmail::dispatch($scheduling, $request->member_id);
            return response()->json([
                'status' => true,
                'message' => 'Scheduling created successfully',
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Error',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function getMaintenanceAndOperationsTeam()
    {
        $teams = [
            'maintenance_team' => User::where('user_type', 'maintenance')->select('name', 'email', 'id')->get(),
            'operation_team' => User::where('user_type', 'operation')->select('name', 'email', 'id')->get(),
        ];

        return response()->json([
            'status' => true,
            'message' => 'Maintenance and Operations team',
            'data' => $teams
        ]);
    }

    public function toDoList(Request $request)
    {
        try {
            $user = auth()->user();
            $facilityId = current_facility($user->id);
            $scheduling = Scheduling::where('member_id', $user->id)
                ->where('facility_id', $facilityId)
                ->get();
            return response()->json([
                'success' => true,
                'data' => $scheduling,
                'message' => 'To Do List of Current User'
            ], 200);

        } catch (Exception $e) {
            Log::error('Error fetching to-do list: ' . $e->getMessage(), ['user_id' => $user->id]);
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while fetching the to-do list.'
            ], 500);
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
     * Display the specified resource.
     */
    public function show(scheduling $scheduling)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(scheduling $scheduling)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateschedulingRequest $request, scheduling $scheduling)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(scheduling $scheduling)
    {
        //
    }
}
