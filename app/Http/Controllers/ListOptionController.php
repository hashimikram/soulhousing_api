<?php

namespace App\Http\Controllers;

use App\Models\ListOption;
use Illuminate\Http\Request;

class ListOptionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $list = ListOption::all();
        $groupData = [];
        foreach ($list as $data) {
            $types = $data->list_id;
            if (!isset($groupData[$types])) {
                $groupData[$types] = [];
            }
            $groupData[$types][] = $data;
        }
        return response()->json([
            'code' => 'success',
            'data' => $groupData,
        ], 200);
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(ListOption $listOption)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ListOption $listOption)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ListOption $listOption)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ListOption $listOption)
    {
        //
    }
}
