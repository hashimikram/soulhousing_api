<!DOCTYPE html>
<html lang="en">
@php
    $encounter = \App\Models\PatientEncounter::find($encounter_id);
    $encounter_type = \App\Models\ListOption::find($encounter->encounter_type);
    $wounds = $encounter ? \App\Models\Wound::where('encounter_id', $encounter_id)->first() : null;
    $woundDetails = $wounds ? \App\Models\WoundDetails::where('wound_id', $wounds->id)->get() : [];
    $patient = $encounter ? \App\Models\patient::find($encounter->patient_id) : null;
    $sections = $encounter ? \App\Models\EncounterNoteSection::where('encounter_id', $encounter_id)->get() : [];
    \Illuminate\Support\Facades\Log::info($sections);
@endphp
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>{{$patient->first_name}} {{$patient->last_name}}</title>
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"
        rel="stylesheet"
    />
    <style>
        .container-warning {
            margin: auto;
            padding: 30px;
            box-shadow: 0 .125rem .25rem rgba(0, 0, 0, .075) !important;
            background-color: #ffffff;
            height: 100%;
        }

        .container-warning p {
            margin: 10px 0px;
        }

        .soul-detail-bio {
            float: right;
            width: 70%;
            margin-top: 10px;
        }

        .soul-detail-bio th, .soul-detail-bio td {
            font-size: 12px;
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

        .img-brand-soul {
            float: left;
            width: 20%;
            margin-bottom: 30px;
        }

        .img-brand-soul img {
            width: 100%;
        }

        ul, li, a {
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .clear-both {
            clear: both;
        }

        .user-name {
            margin-left: 12px;
        }

        .content-left-soul {
            float: left;
            width: 60%;
            margin-bottom: 20px;
        }

        .content-right-soul {
            float: right;
            width: 40%;
            margin-bottom: 20px;
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
<div class="container-warning">


    @if($patient)
        <div class="img-brand-soul">
            <img src="{{ asset('assets/admin/images/logo-blue-latest.png') }}" alt="Brand Logo"/>
        </div>
        <div class="soul-detail-bio">
            <h6>{{ $patient->first_name }} {{ $patient->last_name }}</h6>
            <table style="width: 100%;">
                <tr>
                    <th>Date of Birth</th>
                    <td>{{ date('d-M-Y', strtotime($patient->date_of_birth)) }}</td>
                    <th>Sex</th>
                    <td>{{ $patient->gender }}</td>
                    <td>Age {{ \Carbon\Carbon::parse($patient->date_of_birth)->age }}</td>
                </tr>
                <tr>
                    <th>Encounter Date</th>
                    <td>{{ date('d-M-Y', strtotime($encounter->encounter_date ?? '')) }}</td>
                    <th>Encounter Type</th>
                    <td>{{ $encounter_type->title ?? 'N/A' }}</td>
                </tr>
            </table>
        </div>
        <div class="clear-both"></div>

        <div class="Wound-Evaluation" style="margin-bottom: 30px;">
            <h5>Progress Note</h5>
            @if($sections->isNotEmpty())
                <p>{{ $sections[0]->section_text }}</p>
            @endif
        </div>

        <div class="Wound-Evaluation" style="margin-bottom: 30px;">
            <h5><strong>Wound Evaluation</strong></h5>
            <p>Wound Details</p>
            @if($wounds)
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
                                <td>{{ $wounds->right_dp }}</td>
                                <th>Right</th>
                                <td>{{ $wounds->right_temp }}</td>
                                <th>Right</th>
                                <td>{{ $wounds->right_prick }}</td>
                                <th>Right</th>
                                <td>{{ $wounds->right_mono }}</td>
                            </tr>
                            <tr>
                                <th>Right PT:</th>
                                <td>{{ $wounds->right_pt }}</td>
                                <th>Left</th>
                                <td>{{ $wounds->left_temp }}</td>
                                <th>Left</th>
                                <td>{{ $wounds->left_prick }}</td>
                                <th>Left</th>
                                <td>{{ $wounds->left_mono }}</td>
                            </tr>
                            <tr>
                                <th>Left DP:</th>
                                <td>{{ $wounds->left_dp }}</td>
                            </tr>
                            <tr>
                                <th>Left PT:</th>
                                <td>{{ $wounds->left_pt }}</td>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            @endif
        </div>

        @foreach ($sections->skip(1) as $section)
            <div class="Wound-Evaluation" style="margin-bottom: 30px;">
                <h5>{{ $section->section_title }}</h5>
                <p>{{ $section->section_text }}</p>
            </div>
        @endforeach
    @endif
</div>

<script
    src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
    integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p"
    crossorigin="anonymous"
></script>
<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
    integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF"
    crossorigin="anonymous"
></script>
</body>
</html>
