<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class FacilitySheet implements FromCollection, WithHeadings, WithTitle, WithMapping, WithStyles
{
    protected $facilityId;
    protected $facilityName;
    protected $encounters;

    public function __construct($facilityId, $facilityName, $encounters)
    {
        $this->facilityId = $facilityId;
        $this->facilityName = $facilityName;
        $this->encounters = $encounters;
    }

    public function collection()
    {
        return $this->encounters;
    }

    public function headings(): array
    {
        return [
            'Provider',
            'Patient',
            'Encounter Date',
            'Encounter Type',
            'Specialty',
            'Status'
        ];
    }

    public function map($encounter): array
    {
        return [
            $encounter->provider->name ?? 'N/A',
            $encounter->patient->first_name ?? 'N/A',
            $this->formatDate($encounter->encounter_date),
            $encounter->encounterType->title ?? 'N/A',
            $encounter->specialty_type->title ?? 'N/A',
            $encounter->status == '1' ? 'Signed' : 'Un-Signed'
        ];
    }

    protected function formatDate($date)
    {
        return \Carbon\Carbon::parse($date)->format('Y-m-d');
    }

    public function title(): string
    {
        return $this->facilityName;
    }

    public function styles(Worksheet $sheet)
    {
        // Get the total number of rows
        $highestRow = $sheet->getHighestRow();

        // Style the headings
        $sheet->getStyle('A1:F1')->applyFromArray([
            'font' => [
                'bold' => true,
                'color' => ['rgb' => 'FFFFFF'], // White font color
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'color' => ['rgb' => '0000FF'], // Blue background color
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['rgb' => '000000'], // Black border color
                ],
            ],
        ]);

        // Style the rest of the columns with padding
        $sheet->getStyle('A2:F'.$highestRow)->applyFromArray([
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                'wrapText' => true,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['rgb' => 'CCCCCC'], // Light gray border color
                ],
            ],
        ]);

        // Set column widths (optional)
        foreach (range('A', 'F') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        return [
            // Optional: set alignment and font style for the entire sheet
            // 'alignment' => [
            //     'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
            // ],
        ];
    }
}
