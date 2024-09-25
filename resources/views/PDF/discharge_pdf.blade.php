@php use Carbon\Carbon; @endphp
    <!DOCTYPE html>
<html>

<head>
    <title>{{ $patient->first_name }} {{ $patient->last_name }}</title>
    <style>
        @page {
            margin: 0cm 1cm;
        }

        body {
            margin-top: 6cm;
            width: 100%;
            margin-bottom: 2cm;
        }

        header {
            position: fixed;
            top: 1cm;
            left: 0cm;
            right: 0cm;
            height: 4.5cm;
            display: block;
            border-bottom: 1px solid #d5d5d5;
        }

        header .logo {
            float: left;
            width: 40%;
        }

        header .info {
            float: right;
            width: 60%;
            text-align: right;
        }

        footer {
            position: fixed;
            top: 0cm;
            left: 0cm;
            right: 0cm;
            height: 2cm;
        }

        .info li {
            list-style: none;
        }

        .logo ul {
            padding: 0;
        }

        .logo li {
            list-style: none;
        }

        .section-title {
            background-color: #CFCFCF;
            font-weight: bold;
            font-size: 14px;
        }
    </style>
</head>

<body>
<header>
    <div>
        <div class="logo">
            <img src="{{ asset('assets/admin/images/logo-blue-latest.png') }}" style="width: 200px;" alt="Logo">
            <ul class="list-group list-group-flush">
                <li class="list-group-item border-0">Patient
                    Name: {{ $patient->first_name }} {{ $patient->last_name }}</li>
                <li class="list-group-item border-0">Patient
                    Age: {{ Carbon::parse($patient->date_of_birth)->age }}</li>
                <li class="list-group-item border-0">Date of
                    Birth: {{ date('d-M-Y', strtotime($patient->date_of_birth)) }}</li>
                <li class="list-group-item border-0">Admission
                    Date:{{ date('m-d-Y h:s:i a',strtotime($patient_admission->admission_date)) }}</li>
                <li class="list-group-item border-0">Discharge
                    Date: {{ date('m-d-Y h:s:i a',strtotime($discharged_patient->date_of_discharge)) }}</li>
            </ul>
        </div>
        <div class="info">
            <ul class="list-group list-group-flush">
                <li class="list-group-item border-0">{{$patient_admission->staff->name}} {{$patient_admission->staff->details->middle_name}} {{$patient_admission->staff->details->last_name}}
                    {{ $patient_admission->staff->title ?? 'N/A' }}
                </li>
                <li class="list-group-item border-0">NPI# {{$patient_admission->provider->staff->npi ?? 'N/A'}}</li>
                <li class="list-group-item border-0">Soul Housing</li>
                <li class="list-group-item border-0">{{ $patient_admission->facility->name ?? 'N/A' }}</li>
                <li class="list-group-item border-0">{{ $patient_admission->facility->address ?? 'N/A' }}</li>
            </ul>
        </div>
    </div>
</header>

<footer>
    <script type="text/php">
        if(isset($pdf)){
        $x = 502;
        $y = 780;
        $text = "{PAGE_NUM} of {PAGE_COUNT}";
        $font=$fontMetrics->get_font("Arial, Helvetica, sans-serif", "normal");
        $size = 10;
        $color = array(.16,.16,.16);
        $word_space = 0.0;  //  default
        $char_space = 0.0;  //  default
        $angle = 0.0;   //  default
        $pdf->page_text($x, $y, $text, $font, $size, $color, $word_space, $char_space, $angle);
        }
    </script>
</footer>

<main>
    <div class="content">
        <div style="margin-bottom: 20px;">
            <p><strong>Acknowledgment of Discharge:</strong> {{ $discharged_patient->acknowledgment_of_discharge }}</p>
            <p><strong>Release of Liability:</strong> {{ $discharged_patient->release_of_liability }}</p>
            <p><strong>Acknowledgment of Receipt of Belongings and
                    Medication:</strong> {{ $discharged_patient->acknowledgment_of_receipt_of_belongings_and_medication }}
            </p>
            <p><strong>Belongings:</strong> {{ $discharged_patient->belongings }}</p>
            <p><strong>Medications:</strong> {{ $discharged_patient->medications }}</p>
            <p><strong>Patient Signature:</strong> {{ $discharged_patient->patient_signature }}</p>
            <p><strong>Staff Witness Signature:</strong> {{ $discharged_patient->staff_witness_signature }}</p>
            <p><strong>Patient Signature Date:</strong> {{ $discharged_patient->patient_signature_date }}</p>
            <p><strong>Staff Signature Date:</strong> {{ $discharged_patient->staff_signature_date }}</p>
        </div>
    </div>

</main>

</body>

</html>
