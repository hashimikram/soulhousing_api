<?php

namespace App\Http\Controllers;

use App\Models\CptCode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class CptCodeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function search($search_text)
    {
        // Ensure the user is authenticated
        if (!auth()->check()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }


        $searchTerm = $search_text;
        // Base query
        $query = DB::table('problem_quotes');

        // Apply search filter if search term is provided
        if ($searchTerm) {
            $query->where(function ($query) use ($searchTerm) {
                $query->where('code', 'like', '%' . $searchTerm . '%')
                    ->orWhere('description', 'like', '%' . $searchTerm . '%');
            });
        }
        $cptCodes = $query->get();

        // Return the paginated results
        return apiSuccess($cptCodes);
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
    public function show(CptCode $cptCode)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CptCode $cptCode)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CptCode $cptCode)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CptCode $cptCode)
    {
        //
    }
}
