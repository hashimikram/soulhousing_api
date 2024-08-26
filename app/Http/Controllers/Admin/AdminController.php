<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\patient;
use App\Models\PatientEncounter;

class AdminController extends Controller
{
    public function index()
    {
        $all_patients = patient::count();
        $unassign_patients = patient::whereNull('provider_id')->count();
        $assign_patients = patient::whereNotNull('provider_id')->count();
        $signed_encounters = PatientEncounter::where('status', '1')->count();
        $unsigned_encounters = PatientEncounter::where('status', '0')->count();
        return view('backend.index',
            compact('all_patients', 'unassign_patients', 'assign_patients', 'signed_encounters',
                'unsigned_encounters'));
    }
}
