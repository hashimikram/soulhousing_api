<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdmissionDischarge;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdmissionController extends Controller
{
    public function index(Request $request)
    {
        $query = AdmissionDischarge::with(['patient', 'staff', 'facility'])
            ->leftJoin('floors', 'admission_discharges.floor_id', '=', 'floors.id')
            ->leftJoin('rooms', 'admission_discharges.room_id', '=', 'rooms.id')
            ->leftJoin('beds', 'admission_discharges.bed_id', '=', 'beds.id')
            ->select('admission_discharges.*', 'floors.floor_name as floor_name', 'rooms.room_name as room_name', 'beds.bed_title as bed_name');
        // Normalize input data
        $firstName = $request->input('first_name');
        $lastName = $request->input('last_name');
        $providerId = $request->input('provider');
        $facilityId = $request->input('facility');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        // Apply filters based on the request
        if (!empty($firstName)) {
            $query->whereHas('patient', function ($q) use ($firstName) {
                $q->whereRaw('LOWER(first_name) LIKE ?', ['%' . strtolower(trim($firstName)) . '%']);
            });
        }

        if (!empty($lastName)) {
            $query->whereHas('patient', function ($q) use ($lastName) {
                $q->whereRaw('LOWER(last_name) LIKE ?', ['%' . strtolower(trim($lastName)) . '%']);
            });
        }

        if (!empty($providerId)) {
            $query->whereHas('provider', function ($q) use ($providerId) {
                $q->where('id', $providerId);
            });
        }

        if (!empty($facilityId)) {
            $query->whereHas('facility', function ($q) use ($facilityId) {
                $q->where('id', $facilityId);
            });
        }

        if (!empty($startDate) && !empty($endDate)) {
            $query->whereBetween('admission_date',
                [Carbon::parse($startDate)->startOfDay(), Carbon::parse($endDate)->endOfDay()]);
        } elseif (!empty($startDate)) {
            $query->whereDate('admission_date', '>=', Carbon::parse($startDate)->startOfDay());
        } elseif (!empty($endDate)) {
            $query->whereDate('admission_date', '<=', Carbon::parse($endDate)->endOfDay());
        }

        $admissions = $query->orderBy('created_at', 'DESC')->get();
        return view('backend.pages.admissions.index', compact('admissions'));
    }
}
