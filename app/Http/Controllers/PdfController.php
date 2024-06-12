<?php

namespace App\Http\Controllers;

use PDF;
use Illuminate\Http\Request;

class PdfController extends Controller
{
    public function generatePdf()
    {
        $data = [
            'title' => 'Welcome to ItSolutionStuff.com',
            'date' => date('m/d/Y'),
        ];

        $pdf = PDF::loadView('pdf_view', $data);

        return $pdf->download('itsolutionstuff.pdf');
        return $pdf->download('invoice.pdf');
    }
}
