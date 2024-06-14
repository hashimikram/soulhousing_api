<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FileController extends Controller
{
    public function show($name)
    {
        // Assume the images are stored in the public directory under 'images'
        $imagePath = public_path('/uploads/' . $name);

        // Check if the file exists
        if (!file_exists($imagePath)) {
            return response()->json(['error' => 'File not found'], 404);
        }
        // Read the image file
        $image = file_get_contents($imagePath);

        // Determine the MIME type of the image
        $mimeType = mime_content_type($imagePath);
        // Return the image as a response
        return response($image)->header('Content-Type', $mimeType);
    }

    public function show_file(Request $request)
    {
        // Assume the images are stored in the public directory under 'images'
        $imagePath = public_path('/uploads/' . $request->file_name);

        // Check if the file exists
        if (!file_exists($imagePath)) {
            return response()->json(['error' => 'File not found'], 404);
        }

        // Read the image file
        $image = file_get_contents($imagePath);

        // Encode the image data as base64
        $base64Image = base64_encode($image);

        // Determine the MIME type of the image
        $mimeType = mime_content_type($imagePath);

        // Return the image data and metadata as JSON response
        return response()->json([
            'file' => $base64Image,
            'mime_type' => $mimeType
        ]);
    }
}
