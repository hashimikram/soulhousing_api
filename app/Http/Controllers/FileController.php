<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FileController extends Controller
{
    public function show($name)
    {
        // Assume the images are stored in the public directory under 'images'
<<<<<<< HEAD
        $imagePath = public_path('/uploads/' . $name);
=======
<<<<<<< HEAD
        $imagePath = public_path('/uploads/' . $name);
=======
        $imagePath = public_path('storage/uploads/' . $name);
>>>>>>> 1c7f9ed22f1a431c9cef97cd82022b8454954102
>>>>>>> 5f5cac5326938618709759d14757778d0bd916b2

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
}
