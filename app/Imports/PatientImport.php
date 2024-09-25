<?php

namespace App\Imports;

use App\Models\bed;
use App\Models\Facility;
use App\Models\floor;
use App\Models\Patient;
use App\Models\room;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class PatientImport implements ToCollection, WithMultipleSheets
{
    protected $facilityName;

    public function __construct($facilityName)
    {
        $this->facilityName = $facilityName;
        Log::info($facilityName);
    }

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {

            if ($row[0] === null) {
                continue; // Skip empty rows
            }

            // Insert into patients table
            $patient = patient::create([
                'first_name' => $row[0],
                'last_name' => $row[1],
                'medical_no' => $row[3],
                'facility_id' => $this->getFacilityId($this->facilityName),
            ]);

            // Handle Floor, Room, and Bed
            $floorName = $row[5] ?? 'Ground Floor';
            $floor = floor::firstOrCreate([
                'floor_name' => $floorName,
                'facility_id' => $patient->facility_id,
            ]);

            $room = room::firstOrCreate([
                'room_name' => $row[6] ?? 'Room 1',
                'floor_id' => $floor->id,
            ]);

            bed::create([
                'bed_title' => $row[7] ?? 'Bed 1',
                'room_id' => $room->id,
                'patient_id' => $patient->id,
                'status' => 'occupied',
                'occupied_from' => now(),
                'booked_till' => now()->addDays(90),
            ]);


            // Optionally insert data into another table
            // Example: $patient->otherTable()->create([...]);
        }
    }

    private function getFacilityId($facilityName)
    {
        Log::info($facilityName);

        // Find the facility by name
        $facility = Facility::where('name', $facilityName)->first();

        // If facility exists, return its ID; otherwise, return null
        return $facility ? $facility->id : null;
    }


    public function sheets(): array
    {
        return [
            new static($this->facilityName),
        ];
    }
}
