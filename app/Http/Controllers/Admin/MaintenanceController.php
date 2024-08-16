<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tweet;
use Illuminate\Http\Request;


class MaintenanceController extends Controller
{
    public function store(Request $request)
    {
        $tweet = new Tweet();
        $tweet->user_id = auth()->user()->id;
        $tweet->body = $request->description;
        $tweet->facility_id = $request->facility_id;
        if ($request->file('media')) {
            $originalName = $request->file('media')->getClientOriginalName();
            $imagePath = pathinfo($originalName,
                    PATHINFO_FILENAME).'_'.time().'.'.$request->file('media')->getClientOriginalExtension();
            $destinationPath = public_path('uploads');
            $request->file('media')->move($destinationPath, $imagePath);
            $tweet->file_path = $imagePath;
            $tweet->file_name = $imagePath;
        }
        $tweet->date = now();
        $tweet->save();
        return redirect()->route('maintenance.admin_index')->with('success', 'Tweet created successfully!');
    }
}
