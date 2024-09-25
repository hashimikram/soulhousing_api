<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\scheduling;

class SchedulingController extends Controller
{
    public function index()
    {
        $events = scheduling::with(['patient', 'facility', 'user', 'member'])->orderBy('id', 'desc')->get();
        return view('backend.pages.scheduling.index', compact('events'));
    }
}
