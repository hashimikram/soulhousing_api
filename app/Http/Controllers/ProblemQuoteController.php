<?php

namespace App\Http\Controllers;

use App\Models\ProblemQuote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProblemQuoteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function search(Request $request)
    {
        // Ensure the user is authenticated
        if (!auth()->check()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        // Validate the search term
        $request->validate([
            'search_text' => 'nullable|string|min:2',
        ]);

        $searchTerm = $request->input('search_text');

        // Base query
        $query = ProblemQuote::query();

        // Apply search filter if search term is provided
        if ($searchTerm) {
            $query->where(function ($query) use ($searchTerm) {
                $query->where('code', 'like', '%'.$searchTerm.'%')
                    ->orWhere('description', 'like', '%'.$searchTerm.'%');
            });
        }
        $cptCodes = $query->get();

        // Return the paginated results
        return apiSuccess($cptCodes);
    }

    public function search_problem($search_text)
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
                $query->where('code', 'like', '%'.$searchTerm.'%')
                    ->orWhere('description', 'like', '%'.$searchTerm.'%');
            });
        }
        $cptCodes = $query->get();

        // Modify the collection to rename `assessment_notes` to `assessment_input`
        $cptCodes = $cptCodes->map(function ($item) {
            $item->assessment_input = $item->assessment_notes;
            unset($item->assessment_notes);
            return $item;
        });

        // Return the results
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
    public function show(ProblemQuote $problemQuote)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProblemQuote $problemQuote)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProblemQuote $problemQuote)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProblemQuote $problemQuote)
    {
        //
    }
}
