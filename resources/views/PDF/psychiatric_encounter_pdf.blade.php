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
            margin-top: 200px;
        }

        ul {
            list-style: none;
            padding: 0;
        }

        li {
            padding: 0;
            margin: 0;
        }

        .section-title {
            font-weight: bold;
            display: inline;
        }

        .section-text {
            font-weight: normal;
            display: inline;
        }

        .page-break {
            page-break-before: always;
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
    @foreach($encounter_notes as $data)
        @if ($data->section_slug == 'mental_status_examination')
            @if (!$loop->first)
                <div class="page-break"></div>
            @endif
            <h5>{{ $data->section_title }}</h5>
            <div class="section-text">
                @php
                    $section_text = html_entity_decode($data->section_text);
                                if ($data->section_slug == 'mental_status_examination') {
                                    $section_text = str_replace(
                                        [
                                            'appearance:', 'alert:', 'behavior:', 'speech:', 'mood:', 'affect:', 'process:', 'content:',
                                            'delusions:', 'suicidal_ideations:', 'homicidal_ideations:', 'aggressions:',
                                            'Memory_Immediate:', 'recent:', 'retention_concentration:', 'impulse_control:', 'sleep:',
                                            'appetite:', 'judgment:', 'insight:'
                                        ],
                                        [
                                            '<b>Appearance:</b>', '<b>Alert:</b>', '<b>Behavior:</b>', '<b>Speech:</b>', '<b>Mood:</b>', '<b>Affect:</b>',
                                            '<b>Process:</b>', '<b>Content:</b>', '<b>Delusions:</b>', '<b>Suicidal Ideations:</b>',
                                            '<b>Homicidal Ideations:</b>', '<b>Aggressions:</b>', '<b>Memory Immediate:</b>',
                                            '<b>Recent:</b>', '<b>Retention Concentration:</b>', '<b>Impulse Control:</b>', '<b>Sleep:</b>',
                                            '<b>Appetite:</b>', '<b>Judgment:</b>', '<b>Insight:</b>'
                                        ],
                                        $section_text
                                    );
                                }
                @endphp
                {!! nl2br($section_text) !!}
            </div>
            @if ($data->section_slug == 'mental_status_examination')
                <div class="page-break"></div>
            @endif
        @else
            <div style="margin-bottom: 20px">
                <span class="section-title">{{ $data->section_title }}: </span>
                <span class="section-text">{!! nl2br(html_entity_decode($data->section_text)) !!}</span>
            </div>
        @endif
    @endforeach
</div>
</body>
</html>
