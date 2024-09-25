<?php

namespace App\Exports;

use App\Models\PatientEncounter;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class EncounterExport implements WithMultipleSheets
{
    use Exportable;

    public function sheets(): array
    {
        // Get all encounters grouped by facility
        $encountersGroupedByFacility = PatientEncounter::with([
            'provider',
            'providerPatient',
            'patient',
            'signedBy',
            'encounterType',
            'specialty_type',
            'parentEncounter',
            'facility'
        ])->get()->groupBy('location');

        $sheets = [];
        foreach ($encountersGroupedByFacility as $facilityId => $encounters) {
            // Create a new sheet for each facility
            $facilityName = $encounters->first()->facility->name;
            $sheets[] = new FacilitySheet($facilityId, $facilityName, $encounters);
        }

        return $sheets;
    }
}
