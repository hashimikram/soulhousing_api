<!DOCTYPE html>
<html>
<head>
    <title>{{ $patient->first_name }} {{$patient->last_name}}</title>
    <style>
        @page {
            margin: 100px 50px;
        }

        header {
            position: fixed;
            top: -80px;
            left: 0px;
            right: 0px;
            height: 60px;
            width: 100%;
        }

        header .logo {
            float: left;
            width: 20%;
        }

        header .info {
            float: right;
            width: 75%;
            text-align: right;
        }

        footer {
            position: fixed;
            bottom: -60px;
            left: 0px;
            right: 0px;
            height: 50px;
            text-align: center;
            font-size: 12px;
        }

        .content {
            margin-top: 100px;
        }

        ul {
            list-style: none;
            padding: 0;
        }

        li {
            padding: 0;
            margin: 0;
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

        .Evaluation-table th, .Evaluation-table td {
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
    <div class="logo">
        <img src="{{ asset('assets/admin/images/logo-blue-latest.png') }}" style="width: 100%;" alt="Logo">
    </div>
    <div class="info">
        <ul class="list-group list-group-flush">
            <li class="list-group-item border-0">Eileen Murphy-Sinclair FNP-C</li>
            <li class="list-group-item border-0">NPI# 1598536906</li>
            <li class="list-group-item border-0">Soul Housing</li>
            <li class="list-group-item border-0">145 S. Fairfax Ave, Suite 200,</li>
            <li class="list-group-item border-0">Los Angeles, CA 90036</li>
        </ul>
    </div>
</header>

<footer>
    <script type="text/php">
        if (isset($pdf)) {
            $pdf->page_script('
                $font = $fontMetrics->get_font("Arial, Helvetica, sans-serif", "normal");
                $size = 12;
                $pageText = "Page " . $PAGE_NUM . " of " . $PAGE_COUNT;
                $y = 15;
                $x = 520;
                $pdf->text($x, $y, $pageText, $font, $size);
            ');
        }
    </script>
</footer>

<div class="content">
    <p>Patient Name: {{ $patient->first_name }} {{$patient->last_name}}</p>
    <p>Patient Age: {{ $patient->age }}</p>
    <p>Date of Birth: {{ date('d-M-Y', strtotime($patient->date_of_birth)) }}</p>
    <p>Sex: {{ $patient->gender }}</p>
    <p>Patient Age: {{ \Carbon\Carbon::parse($patient->date_of_birth)->age }}</p>
    <p>Encounter Type: {{ $encounter_type->title ?? 'N/A' }}</p>
    <p>Encounter Date: {{ formatDate($encounter->date) }}</p>
    <div class="clear-both"></div>
    <div class="Wound-Evaluation" style="margin-bottom: 30px;">
        <h5>Progress Note</h5>
        @if($encounter_notes->isNotEmpty())
            <p>{{ $encounter_notes[0]->section_text }}</p>
        @endif
    </div>

    <div class="Wound-Evaluation" style="margin-bottom: 30px;">
        <h5><strong>Wound Evaluation</strong></h5>
        <p>Wound Details</p>
        @if($wound)
            @foreach($woundDetails as $data)
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
                        </thead>
                    </table>
                    <div class="Evaluation-img" style="margin: 40px 0;">
                        @if($data->images)
                            @foreach(json_decode($data->images) as $image)
                                <img src="{{ $image }}" alt="Wound Image"/>
                            @endforeach
                        @endif
                    </div>
                </div>

                <div class="Evaluation-table">
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
                            <td>{{ $data->clinical_signs_of_infection }}</td>
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
                <hr>
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
        @endif
    </div>

    @foreach ($encounter_notes->skip(1) as $section)
        <div class="Wound-Evaluation" style="margin-bottom: 30px;">
            <h5>{{ $section->section_title }}</h5>
            <p>{{ $section->section_text }}</p>
        </div>
    @endforeach

</div>
</body>
</html>
