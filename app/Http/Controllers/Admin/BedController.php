<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\bed;
use Exception;
use Illuminate\Http\Request;

class BedController extends Controller
{
    public function handle_bed_behavior(Request $request)
    {

        $request->validate([
            'bed_id' => 'required|exists:beds,id',
            'patient_id' => 'required|exists:patients,id',
        ]);
        try {
            $bed = bed::where(['id' => $request->bed_id])->first();
            if (isset($bed)) {
                if ($request->btn_name == 'Discharged') {
                    $bed->patient_id = null;
                    $bed->status = 'unprepared';
                    $bed->occupied_from = null;
                    $bed->booked_till = null;
                    $bed->save();
                    return redirect()->back()->with('success', 'Patient Discharged Successfully');
                } else {
                    $bed->status = 'hospitalized';
                    $bed->save();
                    return redirect()->back()->with('success', 'Bed Set to Hospitalized');
                }
            } else {
                return redirect()->back()->with('error', 'Bed not Found');
            }
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }

    }
}
