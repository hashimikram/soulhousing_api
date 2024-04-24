<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;

use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Validator;
use App\Http\Controllers\Api\BaseController as BaseController;

class NoteController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index($patient_id)
    {
        if (!auth()->check()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $notes = Note::with('patient:id,first_name,last_name')->where('patient_id', $patient_id)->get();

        if ($notes->isEmpty()) {
            return response()->json(['message' => 'No notes found for the specified patient'], 404);
        }

        return response()->json($notes);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function search(Request $request, $patient_id)
    {
        // Check if the user is authenticated
        if (!auth()->check()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        // Validate search parameters
            $validator =   $request->validate([
                'search' => 'nullable|string',
            ]);



        // Retrieve notes with patient name by patient_id
        $query = Note::with('patient:id,first_name,last_name')->where('patient_id', $patient_id);

        // Apply search filter if search parameter is provided
        if ($request->has('search')) {
            $searchTerm = $request->input('search');
            $query->where(function ($query) use ($searchTerm) {
                $query->where('title', 'like', "%$searchTerm%");
            });
        }

        // Get the notes
        $notes = $query->get();

        // Check if notes are found
        if ($notes->isEmpty()) {
            return response()->json(['message' => []], 404);
        }

        // Return notes with patient name
        return response()->json($notes);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'title' => 'required',
            'date' => 'required|date',
        ]);

        if (!auth()->check()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        try {
            DB::beginTransaction();
            $note = new Note();
            $note->provider_id = auth()->user()->id;
            $note->patient_id = $validatedData['patient_id'];
            $note->title = $validatedData['title'];
            $note->date = Carbon::createFromFormat('d-m-Y', $validatedData['date'])->format('Y-m-d');
            $note->save();

            DB::commit();

            return response()->json(['message' => 'Note Added'], 200);
        } catch (\Exception $e) {
            DB::rollback();

            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $note = Note::findOrFail($id);
            return response()->json($note);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['error' => 'Note not found'], 404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Note $note)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'title' => 'required',
            'date' => 'required',
            'status' => 'in:0,1',
        ]);

        if (!auth()->check()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        try {
            $note = Note::findOrFail($id);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['error' => 'Note not found'], 404);
        }

        if ($note->provider_id !== auth()->user()->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        try {
            DB::beginTransaction();
            $note->title = $validatedData['title'];
            $note->date = Carbon::createFromFormat('d-m-Y', $validatedData['date'])->format('Y-m-d');
            $note->status = $validatedData['status'];
            $note->save();
            DB::commit();

            return response()->json(['message' => 'Note updated successfully'], 200);
        } catch (\Exception $e) {
            DB::rollback();

            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        if (!is_numeric($id) || $id <= 0) {
            return response()->json(['error' => 'Invalid note ID'], 400);
        }

        try {
            $note = Note::findOrFail($id);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['error' => 'Note not found'], 404);
        }

        if ($note->provider_id !== auth()->user()->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // 4. Attempt to delete the note
        try {
            $note->delete();
        } catch (\Exception $e) {
            return response()->json(['error' =>  $e->getMessage()], 500);
        }

        // 5. Return success response
        return response()->json(['message' => 'Note deleted successfully'], 200);
    }
}
