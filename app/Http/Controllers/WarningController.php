<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreWarningRequest;
use App\Http\Requests\UpdateWarningRequest;
use App\Models\Warning;
use App\Models\WebsiteSetting;
use Illuminate\Support\Facades\Log;

class WarningController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($patient_id)
    {
        $warnings = Warning::where('patient_id', $patient_id)->orderBy('created_at', 'DESC')->get();
        $providerFullName = auth()->user()->name;
        if (count($warnings) > 0) {
            foreach ($warnings as $warning) {
                $warning->file_path = env('APP_URL') . 'public/uploads/' . $warning->file_name;
                $settings = WebsiteSetting::whereIn('key', ['platform_name', 'platform_address', 'platform_contact'])->pluck('value', 'key');
                $warning->soul_housing_address = $settings['platform_address'] ?? '';
                $warning->soul_housing_phone = $settings['platform_contact'] ?? '';
                $warning->website = $settings['platform_name'] ?? '';
                $warning->provider_full_name = auth()->user()->details->title . ' ' . auth()->user()->name . ' ' . auth()->user()->details->last_name;
                $warning->provider_npi = auth()->user()->details->npi;
            }
            return response()->json([
                'status' => true,
                'data' => $warnings
            ]);
        } else {
            return response()->json(['message' => 'No Warning Found'], 400);

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
    public function store(StoreWarningRequest $request)
    {
        $warning = new Warning();
        $warning->staff_name = auth()->user()->name;
        $warning->staff_id = auth()->user()->id;
        $warning->patient_id = $request->patient_id;
        $warning->patient_name = $request->patient_name;
        $warning->date = $request->date;
        $warning->incident_date = $request->incident_date;
        $warning->incident_location = $request->incident_location;
        $warning->reason = $request->reason;
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
                $fileName = uniqid() . '.' . $extension;
                Log::info('File Mime: ' . $mimeType);
                Log::info('File Extension: ' . $extension);

                // Ensure the 'public/uploads' directory exists
                $directory = public_path('uploads');
                if (!file_exists($directory)) {
                    mkdir($directory, 0777, true);
                }

                // Save the file to the public/uploads directory
                $filePath = $directory . '/' . $fileName;
                file_put_contents($filePath, $fileData);

                $publicPath = asset('uploads/' . $fileName);
            } else {
                return response()->json(['error' => 'Invalid media data'], 400);
            }
        }
        $warning->file_name = $fileName;
        $warning->file_path = $filePath;
        $warning->file_size = $file_size;
        $warning->file_type = $mimeType;
        $warning->save();
        return response()->json([
            'status' => true,
            'message' => 'Warning Saved'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Warning $warning)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Warning $warning)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateWarningRequest $request, Warning $warning)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Warning $warning)
    {
        //
    }
}
