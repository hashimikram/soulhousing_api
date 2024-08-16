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

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            font-size: 18px;
            text-align: left;
        }

        th, td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
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
                <li class="list-group-item border-0">Encounter
                    Type: {{ $encounter->encounterType->title ?? 'N/A' }}</li>
                <li class="list-group-item border-0">Encounter Date: {{ formatDate($encounter->date) }}</li>
            </ul>
        </div>
        <div class="info">
            <ul class="list-group list-group-flush">
                <li class="list-group-item border-0">{{ $encounter->provider->name }}
                    {{ $encounter->provider->details->middle_name }}
                    {{ $encounter->provider->details->last_name }}
                    {{ $encounter->specialty_type->title ?? 'N/A' }}
                </li>
                <li class="list-group-item border-0">NPI# {{ $encounter->provider->details->npi ?? 'N/A' }}</li>
                <li class="list-group-item border-0">Soul Housing</li>
                <li class="list-group-item border-0">{{ $encounter->facility->name ?? 'N/A' }}</li>
                <li class="list-group-item border-0">{{ $encounter->facility->address ?? 'N/A' }}</li>
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
        <div class="clear-both"></div>
        <div class="Wound-Evaluation" style="margin-bottom: 30px;">
            <p class="section-title">Progress Note</p>
            @if ($encounter_notes->isNotEmpty())
                <p>{{ $encounter_notes[0]->section_text }}</p>
            @endif
        </div>
        @if ($wound)
            <div class="Wound-Evaluation" style="margin-bottom: 30px;">
                <h5>Progress Notes</h5>
                @foreach ($woundDetails as $data)
                    <div class="Evaluation-table">
                        <table>
                            <tr>
                                <th>Header 1</th>
                                <td><input type="text" class="" value="dsa"></td>
                            </tr>
                            <tr>
                                <th>Header 1</th>
                                <td><input type="text" class="" value="dsa"></td>
                            </tr>
                            <tr>
                                <th>Header 1</th>
                                <td><input type="text" class="" value="dsa"></td>
                            </tr>
                            <tr>
                                <th>Header 1</th>
                                <td><input type="text" class="" value="dsa"></td>
                            </tr>
                            <tr>
                                <th>Header 1</th>
                                <td><input type="text" class="" value="dsa"></td>
                            </tr>
                            <tr>
                                <th>Header 1</th>
                                <td><input type="text" class="" value="dsa"></td>
                            </tr>
                        </table>
                        <div class="Evaluation-img" style="margin: 40px 0;">
                            @if ($data->images)
                                @foreach (json_decode($data->images) as $image)
                                    <img src="{{ $image }}" alt="Wound Image"/>
                                @endforeach
                            @endif
                        </div>
                    </div>
                @endforeach
                <div class="col-6 width-left">
                    <h5 class="text-center">Vascular</h5>
                </div>
                <div class="col-6 width-right">
                    <h5 class="text-center">Neurology</h5>
                </div>
                <div class="clear-both"></div>
                <div class="Evaluation-table">
                    <div class="d-flex align-items-center">
                        <table>
                            <thead>
                            <tr>
                                <th>Pulses</th>
                                <th></th>
                                <th>Skin Temperature</th>
                                <th></th>
                                <th>Pin Prick</th>
                                <th></th>
                                <th>Monofilament</th>
                            </tr>
                            <tr>
                                <th>Right DP:</th>
                                <td>{{ $wound->right_dp }}</td>
                                <th>Right</th>
                                <td>{{ $wound->right_temp }}</td>
                                <th>Right</th>
                                <td>{{ $wound->right_prick }}</td>
                                <th>Right</th>
                                <td>{{ $wound->right_mono }}</td>
                            </tr>
                            <tr>
                                <th>Right PT:</th>
                                <td>{{ $wound->right_pt }}</td>
                                <th>Left</th>
                                <td>{{ $wound->left_temp }}</td>
                                <th>Left</th>
                                <td>{{ $wound->left_prick }}</td>
                                <th>Left</th>
                                <td>{{ $wound->left_mono }}</td>
                            </tr>
                            <tr>
                                <th>Left DP:</th>
                                <td>{{ $wound->left_dp }}</td>
                            </tr>
                            <tr>
                                <th>Left PT:</th>
                                <td>{{ $wound->left_pt }}</td>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        @endif

        @foreach ($encounter_notes->skip(1) as $section)
            <div class="Wound-Evaluation" style="margin-bottom: 30px;">
                <p class="section-title">{{ $section->section_title }}</p>
                <p>{{ $section->section_text }}</p>
            </div>
        @endforeach

    </div>
</main>
</body>

</html>
