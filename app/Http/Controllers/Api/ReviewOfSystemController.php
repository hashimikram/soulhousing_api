<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Api\BaseController;
use App\Models\ReviewOfSystem;
use Illuminate\Http\Request;

class ReviewOfSystemController extends Controller
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
        try {
            ReviewOfSystem::create($request->all());
            $base = new BaseController();
            return $base->sendResponse(null, 'Data Added');
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(ReviewOfSystem $reviewOfSystem)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ReviewOfSystem $reviewOfSystem)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ReviewOfSystem $reviewOfSystem)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ReviewOfSystem $reviewOfSystem)
    {
        //
    }
}
