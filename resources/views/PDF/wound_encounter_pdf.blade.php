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

        .Wound-Evaluation h5 {
            font-size: 14px;
            background-color: #CFCFCF;
            margin: 0px;
        }

        .Wound-Evaluation p {
            font-size: 12px;
            margin: 0px;
        }

        .Evaluation-table table {
            width: 100%;
        }

        .Evaluation-table th,
        .Evaluation-table td {
            font-size: 12px;
        }

        .Evaluation-width {
            width: 33%;
        }

        .Evaluation-img img {
            width: 10%;
            margin-right: 5px;
        }

        .width-left {
            float: left;
            width: 50%;
        }

        .width-right {
            float: right;
            width: 50%;
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
                <li class="list-group-item border-0">Encounter
                    Type: {{ $encounter->encounterType->title ?? 'N/A' }}</li>
                <li class="list-group-item border-0">Encounter
                    Date: {{ date('m-d-Y',strtotime($encounter->encounter_date)) }}</li>
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
        @if ($wound)
            <div class="Wound-Evaluation" style="margin-bottom: 30px;">
                <h5>Progress Notes</h5>
                @foreach ($woundDetails as $data)
                    <div class="Evaluation-table">
                        <table>
                            <thead>
                            <tr>
                                <th>Location</th>
                                <td>{{ $data->location }}</td>
                                <th>Width (cm)</th>
                                <td>{{ $data->width_cm }}</td>
                            </tr>
                            <tr>
                                <th>Wound Type</th>
                                <td>{{ $data->type }}</td>
                                <th>Length (cm)</th>
                                <td>{{ $data->length_cm }}</td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td>{{ $data->status }}</td>
                                <th>Depth (cm)</th>
                                <td>{{ $data->depth_cm }}</td>
                            </tr>
                            <tr>
                                <th>Stage</th>
                                <td>{{ $data->stage }}</td>
                                <th>Area (cm²)</th>
                                <td>{{ $data->area_cm2 }}</td>
                            </tr>
                            <tr>
                            </tr>
                            <tr></tr>
                            </thead>
                        </table>
                        <div class="Evaluation-img" style="margin: 40px 0;">
                            @if ($data->images)
                                @foreach (json_decode($data->images) as $image)
                                    <img src="{{ $image }}" alt="Wound Image"/>
                                @endforeach
                            @endif
                        </div>
                        <table>
                            <thead>
                            <tr>
                                <th>Exudate Amount</th>
                                <td>{{ $data->exudate_amount }}</td>
                                <th>Undermining</th>
                                <td>{{ $data->undermining }}</td>
                                <th>Epithelialization</th>
                                <td>{{ $data->epithelialization }}</td>
                            </tr>
                            <tr>
                                <th>Exudate Type</th>
                                <td>{{ $data->exudate_type }}</td>
                                <th>Tunneling</th>
                                <td>{{ $data->tunneling }}</td>
                                <th>Pain Level</th>
                                <td>0/10</td>
                            </tr>
                            <tr>
                                <th>Granulation Tissue</th>
                                <td>{{ $data->granulation_tissue }}</td>
                                <th>Sinus Tract (cm)</th>
                                <td>{{ $data->sinus_tract_cm }}</td>
                                <th>Odor</th>
                                <td>{{ $data->odor }}</td>
                            </tr>
                            <tr>
                                <th>Fibrous Tissue</th>
                                <td>{{ $data->fibrous_tissue }}</td>
                                <th>Exposed Structures</th>
                                <td>{{ $data->exposed_structures }}</td>
                                <th>Infection</th>
                                <td>{{ $data->infection }}</td>
                            </tr>
                            <tr>
                                <th>Necrotic Tissue</th>
                                <td>{{ $data->necrotic_tissue }}</td>
                                <th>Periwound Color</th>
                                <td>{{ $data->periwound_color }}</td>
                                <th>Clinical Signs of Infection</th>
                                <td>
                                    @php
                                        $clinical_signs_of_infection = json_decode(
                                            $data->clinical_signs_of_infection,
                                        );
                                    @endphp
                                    @if($clinical_signs_of_infection)
                                        @foreach ($clinical_signs_of_infection as $details_signs)
                                            {{ $details_signs }}<br>
                                        @endforeach
                                    @endif

                                </td>
                            </tr>
                            <tr>
                                <th>Wound Bed</th>
                                <td>{{ $data->wound_bed }}</td>
                                <th>Wound Edges</th>
                                <td>{{ $data->wound_edges }}</td>
                                <th>Wound Duration</th>
                                <td>{{ $data->wound_duration }}</td>
                            </tr>
                            </thead>
                        </table>
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
        @foreach ($encounter_notes as $data)
            <div class="Wound-Evaluation" style="margin-bottom: 30px;">
                @if($data->section_slug == 'assessments')
                    @php
                        $assessments = json_decode($data->assessment_note, true);
                    @endphp
                    @if(is_array($assessments) && !empty($assessments))
                        <p class="section-title">Assessment Notes: </p>
                        @foreach($assessments as $details)
                            <p><strong>Code:</strong> {{ $details['Code'] ?? 'N/A' }}</p>
                            <p><strong>Description:</strong> {{ $details['Description'] ?? 'N/A' }}</p>
                            <p><strong>Assessment Input:</strong> {{ $details['assessment_input'] ?? 'N/A' }}</p>
                            <hr>
                        @endforeach
                    @endif
                @endif

                @if(!empty($data->section_text))
                    <p class="section-title">{{ $data->section_title }}: </p>
                    <p class="section-text">{!! nl2br($data->section_text) !!}</p>
                @endif
            </div>
        @endforeach

    </div>
</main>
</body>

</html>
