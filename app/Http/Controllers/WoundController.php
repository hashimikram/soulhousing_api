<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreWoundRequest;
use App\Http\Requests\UpdateWoundRequest;
use App\Models\Wound;
use App\Models\WoundDetails;

class WoundController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreWoundRequest $request)
    {
        $data = $request->all();
        $data['provider_id'] = auth()->user()->id;

        // Check if a wound record already exists for the given encounter_id
        $existingWound = Wound::where('encounter_id', $request->encounter_id)->first();

        if ($existingWound) {
            // Update the existing wound record
            $existingWound->update($data);
            $wound = $existingWound;
        } else {
            // Create a new wound record
            $wound = Wound::create($data);
        }

        $woundDetails = [];

        // Check if 'wounds' input exists and is an array
        if ($request->has('wounds') && is_array($request->input('wounds'))) {
            foreach ($request->input('wounds') as $woundDetailData) {
                $woundDetailData['wound_id'] = $wound->id;

                if (isset($woundDetailData['images']) && is_array($woundDetailData['images'])) {
                    $images = [];
                    foreach ($woundDetailData['images'] as $image) {
                        $images[] = $this->saveImage($image);
                    }
                    $woundDetailData['images'] = json_encode($images);
                }

                $woundDetailData['provider_id'] = auth()->user()->id;
                $woundDetailData['patient_id'] = $request->patient_id;
                $woundDetailData['encounter_id'] = $request->encounter_id;

                // Check if the wound detail already exists for the given wound_id and encounter_id
                $existingWoundDetail = WoundDetails::where('wound_id', $wound->id)
                    ->where('encounter_id', $request->encounter_id)
                    ->where('location', $woundDetailData['location'])
                    ->where('location', $woundDetailData['location'])
                    ->first();

                if ($existingWoundDetail) {
                    // Update the existing wound detail record
                    $existingWoundDetail->update($woundDetailData);
                    $woundDetails[] = $existingWoundDetail;
                } else {
                    // Create a new wound detail record
                    $woundDetails[] = WoundDetails::create($woundDetailData);
                }
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Data Saved',
            'wound' => $wound,
            'woundDetails' => $woundDetails
        ], 201);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateWoundRequest $request, Wound $wound)
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

    private function saveImage($base64Image)
    {
        if (preg_match('/^data:(\w+)\/(\w+);base64,/', $base64Image, $type)) {
            $base64Image = substr($base64Image, strpos($base64Image, ',') + 1);
            $base64Image = base64_decode($base64Image);
            if ($base64Image === false) {
                return "placeholder.jpg";
            }
            $mimeType = strtolower($type[1]);
            $extension = strtolower($type[2]);
            $filename = uniqid().'.'.$extension;

            // Ensure the 'public/uploads' directory exists
            $directory = public_path('uploads');
            if (!file_exists($directory)) {
                mkdir($directory, 0777, true);
            }

            // Save the file to the public/uploads directory
            $filePath = $directory.'/'.$filename;
            file_put_contents($filePath, $base64Image);

            return asset('uploads/'.$filename);
        } else {
            return "placeholder.jpg";
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Wound $wound)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Wound $wound)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Wound $wound)
    {
        //
    }
}
