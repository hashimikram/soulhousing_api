<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EncounterNoteSection;
use App\Models\ListOption;
use App\Models\patient;
use App\Models\PatientEncounter;
use App\Models\User;
use App\Models\Wound;
use App\Models\WoundDetails;
use Barryvdh\DomPDF\PDF as DomPDF;
use Carbon\Carbon;
use Illuminate\Http\Request;

class EncounterController extends Controller
{
    public function index(Request $request)
    {
        $query = PatientEncounter::with([
            'provider',
            'providerPatient',
            'patient',
            'signedBy',
            'encounterType',
            'specialty_type',
            'parentEncounter',
            'facility'
        ]);

        // Normalize input data
        $firstName = $request->input('first_name');
        $lastName = $request->input('last_name');
        $specialtyId = $request->input('specialty');
        $facilityId = $request->input('facility');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        // Apply filters based on the request
        if (!empty($firstName)) {
            $query->whereHas('patient', function ($q) use ($firstName) {
                $q->whereRaw('LOWER(first_name) LIKE ?', ['%'.strtolower(trim($firstName)).'%']);
            });
        }

        if (!empty($lastName)) {
            $query->whereHas('patient', function ($q) use ($lastName) {
                $q->whereRaw('LOWER(last_name) LIKE ?', ['%'.strtolower(trim($lastName)).'%']);
            });
        }

        if (!empty($specialtyId)) {
            $query->whereHas('specialty_type', function ($q) use ($specialtyId) {
                $q->where('id', $specialtyId);
            });
        }

        if (!empty($facilityId)) {
            $query->whereHas('facility', function ($q) use ($facilityId) {
                $q->where('id', $facilityId);
            });
        }

        if (!empty($startDate) && !empty($endDate)) {
            $query->whereBetween('encounter_date',
                [Carbon::parse($startDate)->startOfDay(), Carbon::parse($endDate)->endOfDay()]);
        } elseif (!empty($startDate)) {
            $query->whereDate('encounter_date', '>=', Carbon::parse($startDate)->startOfDay());
        } elseif (!empty($endDate)) {
            $query->whereDate('encounter_date', '<=', Carbon::parse($endDate)->endOfDay());
        }

        $encounters = $query->orderBy('encounter_date', 'DESC')->get();

        return view('backend.pages.encounters.index', compact('encounters'));
    }

    public function get_pdf($encounter_id, DomPDF $pdf)
    {
        $encounter = PatientEncounter::findOrFail($encounter_id);

        if ($encounter) {
            $check_speciality = ListOption::where('id', $encounter->specialty)->first();

            if ($check_speciality) {
                $patient = Patient::findOrFail($encounter->patient_id);
                $user = User::with('details')->where('id', $encounter->provider_id)->first();
                $encounter_notes = EncounterNoteSection::where('encounter_id', $encounter->id)
                    ->where('patient_id', $encounter->patient_id)
                    ->whereNotNull('section_text')
                    ->get();

                if ($check_speciality->option_id == 'psychiatrist') {
                    $pdf = $pdf->loadView('PDF.psychiatric_encounter_pdf',
                        compact('patient', 'encounter', 'encounter_notes', 'check_speciality', 'user'));
                } elseif ($check_speciality->option_id == 'wound') {
                    $wound = Wound::where('encounter_id', $encounter->id)->first();
                    $woundDetails = $wound ? WoundDetails::where('wound_id',
                        $wound->id)->get() : collect();
                    $pdf = $pdf->loadView('PDF.wound_encounter_pdf',
                        compact('patient', 'encounter', 'encounter_notes', 'wound', 'woundDetails',
                            'check_speciality', 'user'));
                } else {
                    $pdf = $pdf->loadView('PDF.general_encounter_pdf',
                        compact('patient', 'encounter', 'encounter_notes', 'check_speciality', 'user'));
                }

                return $pdf->stream('document.pdf');
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Speciality Not Found'
                ], 404);
            }
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Encounter Not Found'
            ], 404);
        }
    }


}
