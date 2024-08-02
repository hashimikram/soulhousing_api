<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMedicalLetterRequest;
use App\Http\Requests\UpdateMedicalLetterRequest;
use App\Models\MedicalLetter;
use Illuminate\Support\Facades\Log;

class MedicalLetterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($patient_id)
    {
        $MedicalLetter = MedicalLetter::where('patient_id', $patient_id)->orderBy('created_at', 'DESC')->get();
        $providerFullName = auth()->user()->name;
        if (count($MedicalLetter) > 0) {
            foreach ($MedicalLetter as $MedicalLetters) {
                $MedicalLetters->file_path = env('APP_URL').'public/uploads/'.$MedicalLetters->file_name;
                $MedicalLetters->provider_full_name = $providerFullName;
            }
            return response()->json([
                'status' => true,
                'data' => $MedicalLetter
            ]);
        } else {
            return response()->json(['message' => 'No Data Found'], 400);

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
     * Store a newly created resource in storage.
     */
    public function store(StoreMedicalLetterRequest $request)
    {
        $MedicalLetter = new MedicalLetter();
        $MedicalLetter->staff_name = auth()->user()->name;
        $MedicalLetter->subject = 'Medical Letter';
        $MedicalLetter->staff_id = auth()->user()->id;
        $MedicalLetter->patient_id = $request->patient_id;
        $MedicalLetter->patient_name = $request->patient_name;
        $MedicalLetter->date = $request->date;
        $MedicalLetter->incident_date = $request->incident_date;
        $MedicalLetter->incident_location = $request->incident_location;
        $MedicalLetter->reason = $request->reason;
        $fileName = null;

        $filePath = null;
        $file_size = null;
        $mimeType = null;
        if ($request->media) {
            $fileData = $request->input('media');
            if (preg_match('/^data:(\w+)\/(\w+);base64,/', $fileData, $type)) {
                $fileData = substr($fileData, strpos($fileData, ',') + 1);
                $fileData = base64_decode($fileData);
                if ($fileData === false) {
                    return response()->json(['error' => 'Base64 decode failed'], 400);
                }
                $mimeType = strtolower($type[1]);
                $extension = strtolower($type[2]);
                $fileName = uniqid().'.'.$extension;
                Log::info('File Mime: '.$mimeType);
                Log::info('File Extension: '.$extension);

                // Ensure the 'public/uploads' directory exists
                $directory = public_path('uploads');
                if (!file_exists($directory)) {
                    mkdir($directory, 0777, true);
                }

                // Save the file to the public/uploads directory
                $filePath = $directory.'/'.$fileName;
                file_put_contents($filePath, $fileData);

                $publicPath = asset('uploads/'.$fileName);
            } else {
                return response()->json(['error' => 'Invalid media data'], 400);
            }
        }
        $MedicalLetter->file_name = $fileName;
        $MedicalLetter->file_path = $filePath;
        $MedicalLetter->file_size = $file_size;
        $MedicalLetter->file_type = $mimeType;
        $MedicalLetter->save();
        return response()->json([
            'status' => true,
            'message' => 'Medical Letter Saved'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(MedicalLetter $medicalLetter)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MedicalLetter $medicalLetter)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMedicalLetterRequest $request, MedicalLetter $medicalLetter)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MedicalLetter $medicalLetter)
    {
        //
    }
}
