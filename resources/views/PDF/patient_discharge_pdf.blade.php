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

        li {
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
                    Age: {{ \Carbon\Carbon::parse($patient->date_of_birth)->age }}</li>
                <li class="list-group-item border-0">Date of
                    Birth: {{ date('d-M-Y', strtotime($patient->date_of_birth)) }}</li>
                <li class="list-group-item border-0">Admission
                    Date: {{ formatDate($admission->admission_date) }}</li>
                <li class="list-group-item border-0">Date of Discharge
                    Date: {{ formatDate($dischargeForm['date_of_discharge']) }}</li>
            </ul>
        </div>
        <div class="info">

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
        <div>
            <p class="section-title">{{ ucwords(strtolower('ACKNOWLEDGMENT OF DISCHARGE:')) }}</p>
            <p class="section-text">{!! nl2br($dischargeForm['acknowledgment_of_discharge']) !!}</p>
        </div>
        <div>
            <p class="section-title">{{ ucwords(strtolower('RELEASE OF LIABILITY:')) }}</p>
            <p class="section-text">{!! nl2br($dischargeForm['release_of_liability']) !!}</p>
        </div>
        <div>
            <p class="section-title">
                {{ ucwords(strtolower('ACKNOWLEDGMENT OF RECEIPT OF BELONGINGS AND MEDICATION:')) }}</p>
            <p class="section-text">{!! nl2br($dischargeForm['acknowledgment_of_receipt_of_belongings_and_medication']) !!}</p>
        </div>
        <div>
            <p class="section-title">{{ ucwords(strtolower('Belongings:')) }}</p>
            <p class="section-text">{!! nl2br($dischargeForm['belongings']) !!}</p>
        </div>
        <div>
            <p class="section-title">{{ ucwords(strtolower('Medications:')) }}</p>
            <p class="section-text">{!! nl2br($dischargeForm['medications']) !!}</p>
        </div>
        <ul>
            <li class="list-group-item border-0">Patient Signature
                Date: {{ formatDate($dischargeForm['patient_signature_date']) }}</li>
            <li class="list-group-item border-0">Staff
                Name: {{ $user->name }} {{ $user->details->middle_name }} {{ $user->details->last_name }} </li>
            <li class="list-group-item border-0">Staff Position: {{ $user->user_type }}</li>
            <li class="list-group-item border-0">Staff Signature
                Date: {{ formatDate($dischargeForm['staff_signature_date']) }}</li>
            <li class="list-group-item border-0">Socially Oriented United Living, LLC (Soul Housing)</li>
            <li class="list-group-item border-0">Address :
                UK
            </li>
            <li class="list-group-item border-0">Phone :
                +09837656728
            </li>
            <li class="list-group-item border-0">Website:
                https://care-soulhousing.anchorstech.net/
            </li>

        </ul>
    </div>


</main>

</body>

</html>
