<?php

namespace App\Imports;

use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Events\BeforeImport;

class MultiSheetImport implements WithMultipleSheets, WithEvents
{
    /**
     * Handle multiple sheets dynamically.
     *
     * @return array
     */
    public function sheets(): array
    {
        // Returning an empty array to handle all sheets dynamically.
        return [];
    }

    /**
     * Register the event to log all sheet names before import.
     *
     * @return array
     */
    public function registerEvents(): array
    {
        return [
            BeforeImport::class => function (BeforeImport $event) {
                $spreadsheet = $event->getReader()->getDelegate();
                $sheetNames = $spreadsheet->getSheetNames();

                foreach ($sheetNames as $sheetName) {
                    Log::info('Sheet name: '.$sheetName);
                }
            },
        ];
    }
}
