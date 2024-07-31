@php
    $patient = App\Models\patient::find($patient_id);
        $encounter = App\Models\PatientEncounter::where('patient_encounters.id', $encounter_id)
        ->leftjoin('list_options as encounter_type', 'encounter_type.id', '=',
            'patient_encounters.encounter_type')
            ->select('encounter_type.title','patient_encounters.*')->first();
    $foreachSections = App\Models\EncounterNoteSection::where('encounter_id', $encounter_id)
        ->whereIn('section_slug', ['assessments', 'mental_status_examination'])
        ->pluck('id');

    $sections = App\Models\EncounterNoteSection::where('encounter_id', $encounter_id)
        ->whereNotIn('id', $foreachSections)
        ->get();

    $mental_health_section = App\Models\EncounterNoteSection::where('encounter_id', $encounter_id)
        ->where('section_slug', 'mental_status_examination')
        ->first();

    $formattedSections = $mental_health_section ? json_decode($mental_health_section->section_json, true) : [];
@endphp
    <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{$patient->first_name}} {{$patient->last_name}}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet"/>
    <style>
        .container-warning {
            width: 850px;
            margin: auto;
            padding: 30px;
            box-shadow: 0 .125rem .25rem rgba(0, 0, 0, .075) !important;
            background-color: #ffffff;
            height: 100%;
        }

        .container-warning p {
            margin: 10px 0;
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
            margin: 0;
        }

        .Wound-Evaluation p {
            font-size: 12px;
            margin: 0;
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

        .Evaluation-img img {
            width: 100%;
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

        .Evaluation-table {
            width: 100%;
        }

        .width-left {
            float: left;
            width: 35%;
        }

        .width-right {
            float: right;
            width: 60%;
        }

        .psychiatric-height {
            margin-bottom: 10px;
        }

        .psychiatric-headings {
            margin-top: 20px;
        }

        .psychiatric-mental-headings {
            margin-top: 10px;
        }

        .psychiatric-mental-headings h5 {
            font-size: 14px;
            background-color: #CFCFCF;
            margin: 0;
        }

        .form-psychiatric {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }

        .form-psychiatric input[type="checkbox"] {
            margin-right: 10px;
        }

        .form-psychiatric label {
            margin: 0;
            font-size: 12px;
        }

    </style>
</head>

<body>
<div class="container-warning">

    <div class="img-brand-soul">
        <img src="{{ asset('assets/admin/images/logo-blue-latest.png') }}" alt="Brand Logo">
    </div>
    <div class="soul-detail-bio">
        <h6>{{ $patient->first_name }} {{ $patient->last_name }}</h6>
        <table class="table">
            <tr>
                <th>Date of Birth</th>
                <td>{{ date('d-M-Y', strtotime($patient->date_of_birth)) }}</td>
                <th>Sex</th>
                <td>{{ $patient->gender }}</td>
                <td>Age {{ \Carbon\Carbon::parse($patient->date_of_birth)->age }}</td>
            </tr>
            <tr>
                <th>Encounter Date</th>
                <td>{{ date('d-M-Y', strtotime($encounter->encounter_date)) }}</td>
                <th>Encounter Type</th>
                <td>{{ $encounter->title }}</td>
            </tr>
        </table>
    </div>
    <div class="clear-both"></div>
    <div class="psychiatric-headings">
        <h5>PSYCHIATRIC NOTES</h5>
    </div>

    @php
        $sectionsData = [
            'wound_type' => ['Wound'],
           'patient' => [$patient->first_name . ' ' . $patient->last_name],
            'dob' => ['1/2/2024'],
            'facility' => ['unique'],
            'hpi_initial_evaluation' => ['INITIAL'],
            'id' => ['67889'],
            'reason_for_consult' => ['Initial']
        ];
    @endphp

    @foreach($sectionsData as $key => $value)
        <div class="psychiatric-height">
            <table>
                <tr>
                    <th>{{ ucwords(str_replace('_', ' ', $key)) }}:</th>
                    <td>{{ $value[0] }}</td>
                </tr>
            </table>
        </div>
    @endforeach

    @foreach(['appearance', 'alert', 'behavior', 'speech', 'mood', 'affect', 'process', 'content', 'delusions', 'suicidal_ideations', 'homicidal_ideations', 'aggressions'] as $section)
        <div class="psychiatric-mental-headings">
            <h5>{{ ucwords(str_replace('_', ' ', $section)) }}</h5>
        </div>
        <div class="psychiatric-mental-headings d-grid-psychiatric">
            @php
                $section_option = match ($section) {
                    'appearance' => ['Kemp', 'Unkempt', 'Disheveled', 'Poor Hygiene', 'Malodorous'],
                    'alert' => ['Yes', 'No'],
                    'behavior' => ['Normal', 'Coorperative', 'Restless', 'Agitated', 'Hostile', 'Suspicious', 'MotorRetardation'],
                    'speech' => ['Verbal', 'Normal_Rate', 'Hyper_Verbal', 'Pressured', 'Slow', 'Soft', 'Slurred', 'Mumbled', 'Nonverbal'],
                    'mood' => ['Euthymic', 'Depressed', 'Anxious', 'Elevated', 'Irritable', 'Agitated'],
                    'affect' => ['Appropriate', 'Labile', 'Expansive', 'Anxious', 'Worrisome', 'Blunted', 'Flat', 'Constricted', 'Apathetic'],
                    'process' => ['Intact', 'Circumstantial', 'Tangential', 'Flight', 'Loose', 'Perseveration', 'Assess'],
                    'content' => ['Denied', 'Auditory', 'Visual', 'Tactile', 'Olfactory', 'Gustatory', 'Hypnogogic', 'Hypnopompic', 'Derealization', 'Depersonalization'],
                    'delusions' => ['Denied', 'Paranoid', 'Grandiose', 'Somantic', 'Jealousy', 'Nihilistic'],
                    'suicidal_ideations' => ['Yes', 'No', 'Hx'],
                    'homicidal_ideations' => ['Yes', 'No', 'Hx'],
                    'aggressions' => ['Yes', 'No', 'Hx'],
                };
                $save_option = $formattedSections[$section] ?? [];
            @endphp

            @foreach($section_option as $option)
                @php
                    $label = ucwords(str_replace('_', ' ', $option));
                @endphp
                <div class="form-psychiatric">
                    <input type="checkbox" id="{{ $section }}-{{ $option }}" name="{{ $section }}[]"
                           value="{{ $option }}"
                        {{ in_array($option, $save_option) ? 'checked' : '' }}>
                    <label class="chek-margin-left" for="{{ $section }}-{{ $option }}">{{ $label }}</label>
                </div>
            @endforeach
        </div>
    @endforeach
</div>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
        integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
        integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF"
        crossorigin="anonymous"></script>

</body>
</html>
