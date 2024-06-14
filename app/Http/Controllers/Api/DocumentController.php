<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Api\BaseController as BaseController;

class DocumentController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index($patient_id)
    {
        if (!auth()->check()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        $documents = Document::with('patient:id,first_name,last_name')->where('patient_id', $patient_id)->get();

        foreach ($documents as $document) {
            $document->provider = auth()->user()->name;
        }

        if ($documents->isEmpty()) {
            return response()->json(['message' => 'No Document Found for the specified patient'], 400);
        }
        return response()->json($documents);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function search(Request $request)
    {
        if (!auth()->check()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        $searchTerm = $request->search_text;
        $patient_id = $request->patient_id;
        $allergy = Document::with('patient:id,first_name,last_name')
            ->where('patient_id', $patient_id)
            ->where(function ($query) use ($searchTerm) {
                $query->where('title', 'like', '%' . $searchTerm . '%')
                    ->orWhere('type', 'like', '%' . $searchTerm . '%')
                    ->orWhere('description', 'like', '%' . $searchTerm . '%')
                    ->orWhereHas('patient', function ($subQuery) use ($searchTerm) {
                        $subQuery->where('first_name', 'like', '%' . $searchTerm . '%')
                            ->orWhere('last_name', 'like', '%' . $searchTerm . '%');
                    });
            })
            ->get();

        return apiSuccess($allergy);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'title' => 'required',
            'type' => 'required',
            'date' => 'required|date',
            // 'file' => 'file|mimes:png,jpeg,pdf,doc,docx|max:2048',
            'description' => 'nullable|string',
        ]);

        if (!auth()->check()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $formattedFileSize = NULL;
        $fileName = NULL;

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileSize = $file->getSize();
            $formattedFileSize = formatFileSize($fileSize);
            $fileName = date('YmdHi') . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('uploads', $fileName, 'public');
        }

        try {
            DB::beginTransaction();

            $document = new Document();
            $document->provider_id = auth()->user()->id;
            $document->patient_id = $validatedData['patient_id'];
            $document->title = $validatedData['title'];
            $document->type = $validatedData['type'];
            $document->description = $validatedData['description'];
            $document->date = $validatedData['date'];
            $document->file_size = $formattedFileSize;
            $document->file = $fileName;
            $document->save();

            DB::commit();
            return response()->json(['message' => 'Document Added'], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }



    /**
     * Display the specified resource.
     */
    public function show(Document $document)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Document $document)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'document_id' => 'required',
            'title' => 'required',
            'type' => 'required',
            'date' => 'required|date',
            'file' => 'file|mimes:png,jpeg,pdf,doc,docx|max:2048',
            'description' => 'nullable|string',
        ]);

        if (!auth()->check()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        try {
            $document = Document::findOrFail($validatedData['document_id']);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['error' => 'Document not found'], 404);
        }

        $fileName = $document->file;
        $formattedFileSize = $document->file_size;

        if ($request->hasFile('file')) {
            $imagePath = public_path('storage/uploads/' . $document->file);
            if ($document->file != NULL) {
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }
            $file = $request->file('file');
            $fileName = date('YmdHi') . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $fileSize = $file->getSize();
            $formattedFileSize = formatFileSize($fileSize);
            $file->storeAs('uploads', $fileName, 'public');
        }

        try {
            DB::beginTransaction();

            $document->title = $validatedData['title'];
            $document->type = $validatedData['type'];
            $document->description = $validatedData['description'];
            $document->date = $validatedData['date'];
            $document->file_size = $formattedFileSize;
            $document->file = $fileName;
            $document->save();

            DB::commit();
            return response()->json(['message' => 'Document Updated'], 200);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        if (!is_numeric($id) || $id <= 0) {
            return response()->json(['error' => 'Invalid Document ID'], 400);
        }

        try {
            $document = Document::FindOrFail($id);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['error' => 'Document not found'], 404);
        }

        try {
            $document->delete();
        } catch (\Exception $e) {
            return response()->json(['error' =>  $e->getMessage()], 500);
        }

        return response()->json(['message' => 'Document deleted successfully'], 200);
    }
}
