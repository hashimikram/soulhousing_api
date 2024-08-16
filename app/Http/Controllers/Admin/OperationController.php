<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Operation;
use Illuminate\Http\Request;

class OperationController extends Controller
{
    public function index()
    {
        $operation = Operation::with(['user', 'facility'])->orderBy('created_at', 'DESC')->paginate('10');
        return view('backend.pages.operation.index', compact('operation'));
    }

    public function store(Request $request)
    {
        $tweet = new Operation();
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
        return redirect()->route('operations.index')->with('success', 'Operation created successfully!');
    }
}
