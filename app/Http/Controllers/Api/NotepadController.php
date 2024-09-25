<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Notepad;
use App\Http\Requests\StoreNotepadRequest;
use Illuminate\Support\Str;
use App\Http\Requests\UpdateNotepadRequest;
use Carbon\Carbon;

class NotepadController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($patient_id)
    {
        $notepad = Notepad::where('patient_id', $patient_id)->orderBy('created_at', 'DESC')->get();
        foreach ($notepad as $data) {
            $data->provider_name = auth()->user()->name;
        }
        return response()->json([
            'status' => true,
            'message' => 'NotePad Data',
            'notepad' => $notepad,
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
    public function store(StoreNotepadRequest $request)
    {
        try {
            $notepad = new Notepad();
            $notepad->patient_id = $request->patient_id;
            $notepad->provider_id = auth()->user()->id;
            $notepad->facility_id = current_facility(auth()->user()->id);
            $formattedDate = $request->note_date;
            $cleanedDateString = preg_replace('/\s*\(.*?\)/', '', $formattedDate);
            $date = date('Y-m-d H:i:s', strtotime($cleanedDateString));
            $notepad->note_date = $date ?? Carbon::now();
            $notepad->title = $request->title;
            $notepad->node_desc = $request->node_desc;
            $notepad->content_type = $request->content_type;
            $filename = null;

            // Check if there is a file in the request
            if ($request->filled('file')) {
                $fileData = base64_decode($request->input('file'));
                $extension = 'pdf'; // Adjust this based on the expected file type
                $filename = uniqid() . '.' . $extension;

                // Ensure the 'public/uploads' directory exists
                $directory = public_path('uploads');
                if (!file_exists($directory)) {
                    mkdir($directory, 0777, true);
                }

                // Save the file to the public/uploads directory
                $filePath = $directory . '/' . $filename;
                file_put_contents($filePath, $fileData);
            }
            $notepad->file = $filename;
            $notepad->save();
            return response()->json([
                'status' => true,
                'message' => 'Note Created',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Notepad $notepad)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Notepad $notepad)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateNotepadRequest $request, Notepad $notepad)
    {
        try {
            $notepad = Notepad::findorFail($request->id);
            $formattedDate = $request->note_date;
            $cleanedDateString = preg_replace('/\s*\(.*?\)/', '', $formattedDate);
            $date = date('Y-m-d H:i:s', strtotime($cleanedDateString));
            $notepad->note_date = $date ?? Carbon::now();
            $notepad->title = $request->title;
            $notepad->node_desc = $request->node_desc;
            $notepad->content_type = $request->content_type;
            if ($request->filled('file')) {
                $fileData = base64_decode($request->input('file'));
                $extension = 'pdf'; // Adjust this based on the expected file type
                $filename = uniqid() . '.' . $extension;

                // Ensure the 'public/uploads' directory exists
                $directory = public_path('uploads');
                if (!file_exists($directory)) {
                    mkdir($directory, 0777, true);
                }

                // Save the file to the public/uploads directory
                $filePath = $directory . '/' . $filename;
                file_put_contents($filePath, $fileData);
                $notepad->file = $filename;
            }
            $notepad->save();
            return response()->json([
                'status' => true,
                'message' => 'Note Updated',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Notepad $notepad)
    {
        //
    }
}
