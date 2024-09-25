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
                <li class="list-group-item border-0">Encounter
                    Type: {{ $encounter->encounterType->title ?? 'N/A' }}</li>
                <li class="list-group-item border-0">Encounter
                    Date: {{ date('m-d-Y',strtotime($encounter->encounter_date)) }}</li>
            </ul>
        </div>
        <div class="info">
            <ul class="list-group list-group-flush">
                <li class="list-group-item border-0">{{$encounter->provider->name}} {{$encounter->provider->details->middle_name}} {{$encounter->provider->details->last_name}}
                    {{ $encounter->specialty_type->title ?? 'N/A' }}
                </li>
                <li class="list-group-item border-0">NPI# {{$encounter->provider->details->npi ?? 'N/A'}}</li>
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
        @foreach ($encounter_notes as $data)
            @php
                $section_text = html_entity_decode($data->section_text);
                if ($data->section_slug == 'review-of-systems') {
                    $section_text = str_replace(
                        [
                            'General:',
                            'Skin:',
                            'Head:',
                            'Eyes:',
                            'Ears:',
                            'Nose:',
                            'Throat:',
                            'Neck:',
                            'Chest:',
                            'Respiratory:',
                            'Cardiovascular:',
                            'Gastrointestinal:',
                            'Genitourinary:',
                            'Musculoskeletal:',
                            'Neurological:',
                            'Psychiatric:',
                            'Endocrine:',
                            'Lymphatic:',
                            'Immunologic:',
                        ],
                        [
                            '<b>General:</b>',
                            '<b>Skin:</b>',
                            '<b>Head:</b>',
                            '<b>Eyes:</b>',
                            '<b>Ears:</b>',
                            '<b>Nose:</b>',
                            '<b>Throat:</b>',
                            '<b>Neck:</b>',
                            '<b>Chest:</b>',
                            '<b>Respiratory:</b>',
                            '<b>Cardiovascular:</b>',
                            '<b>Gastrointestinal:</b>',
                            '<b>Genitourinary:</b>',
                            '<b>Musculoskeletal:</b>',
                            '<b>Neurological:</b>',
                            '<b>Psychiatric:</b>',
                            '<b>Endocrine:</b>',
                            '<b>Lymphatic:</b>',
                            '<b>Immunologic:</b>',
                        ],
                        $section_text,
                    );
                }

                if ($data->section_slug == 'physical-exam') {
                    $section_text = str_replace(
                        [
                            'Appearance:',
                            'Skin:',
                            'Head:',
                            'Eyes:',
                            'Ears:',
                            'Nose:',
                            'Throat:',
                            'Neck:',
                            'Lungs:',
                            'Chest:',
                            'Heart',
                            'Abdomen:',
                            'Genitourinary:',
                            'Musculoskeletal:',
                            'Neurological:',
                            'Psychiatric:',
                        ],
                        [
                            '<b>Appearance:</b>',
                            '<b>Skin:</b>',
                            '<b>Head:</b>',
                            '<b>Neck:</b>',
                            '<b>Eyes:</b>',
                            '<b>Ears:</b>',
                            '<b>Nose:</b>',
                            '<b>Throat:</b>',
                            '<b>Neck:</b>',
                            '<b>Lungs:</b>',
                            '<b>Chest:</b>',
                            '<b>Heart:</b>',
                            '<b>Abdomen:</b>',
                            '<b>Genitourinary:</b>',
                            '<b>Musculoskeletal:</b>',
                            '<b>Neurological:</b>',
                            '<b>Psychiatric:</b>',
                        ],
                        $section_text,
                    );
                }
            @endphp

            <div style="margin-bottom: 20px;">
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
                    <p class="section-text">{!! nl2br($section_text) !!}</p>
                @endif
            </div>
        @endforeach
    </div>

</main>

</body>

</html>
