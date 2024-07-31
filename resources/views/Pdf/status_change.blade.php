@php
    $formattedData = [];
    $sections = \App\Models\EncounterNoteSection::where('encounter_id', $encounter_id)->orderBy('id', 'ASC')->get();
    $patient_id = $sections->first()->patient_id;
    $patient = \App\Models\patient::where('id', $patient_id)->first();

    foreach ($sections as $key => $section) {
        $encounter = \App\Models\PatientEncounter::where('id', $encounter_id)->first();
        $check_speciality = \App\Models\ListOption::find($encounter->specialty);
        $fixed_id = null; // Ensure fixed_id is initialized

        if ($encounter->speciality == 'psychiatrist') {
            $fixed_id = 69;
        }

        if ($section->section_slug == 'mental_status_examination') {
            $fixed_id = 71;
        }
        $section_text = $section->section_text ?? '';

        if ($section['section_slug'] == 'review-of-systems') {
            $section_text = str_replace(
                [
                    'General:', 'Skin:', 'Head:', 'Eyes:', 'Ears:', 'Nose:',
                    'Mouth/Throat:', 'Neck:', 'Breasts/Chest:', 'Respiratory:', 'Cardiovascular:',
                    'Gastrointestinal:', 'Genitourinary:', 'Musculoskeletal:', 'Neurological:', 'Psychiatric:', 'Endocrine:',
                    'Hematologic/Lymphatic:', 'Allergic/Immunologic:'
                ],
                [
                    '<b>General:</b>', '<b>Skin:</b>', '<b>Head:</b>', '<b>Eyes:</b>', '<b>Ears:</b>', '<b>Nose:</b>', '
                    <b>Mouth/Throat:</b>',
                    '<b>Neck:</b>', '<b>Breasts/Chest:</b>', '<b>Respiratory:</b>', '<b>Cardiovascular:</b>', '<b>Gastrointestinal:</b>',
                    '<b>Genitourinary:</b>', '<b>Musculoskeletal:</b>', '<b>Neurological:</b>', '<b>Psychiatric:</b>', '<b>Endocrine:</b>',
                    '<b>Hematologic/Lymphatic:</b>', '<b>Allergic/Immunologic:</b>',
                ],
                $section_text
            );
        }

        if ($section['section_slug'] == 'physical-exam') {
            $section_text = str_replace(
                [
                    'General Appearance:', 'Skin:', 'Head:', 'Eyes:', 'Ears:', 'Nose:', 'Mouth & Throat:',
                    'Neck:', 'Chest/Lungs:', 'Heart:', 'Abdomen:', 'Genitourinary:', 'Musculoskeletal:',
                    'Neurological:', 'Psychiatric:'
                ],
                [
                    '<b>General Appearance:</b>', '<b>Skin:</b>', '<b>Head:</b>', '<b>Neck:</b>', '<b>Eyes:</b>', '<b>Ears:</b>',
                    '<b>Nose:</b>', '<b>Mouth & Throat:</b>', '<b>Chest/Lungs:</b>', '<b>Heart:</b>', '<b>Abdomen:</b>',
                    '<b>Genitourinary:</b>', '<b>Musculoskeletal:</b>', '<b>Neurological:</b>', '<b>Psychiatric:</b>'
                ],
                $section_text
            );
        }

        if ($section['section_slug'] == 'wound_evaluation') {
            $formattedData[] = [
                'section_id' => $section->id,
                'section_title' => $section->section_title,
                'section_slug' => $section->section_slug,
                'section_text' => $section_text,
                'id_default' => (int) $section->sorting_order,
                'section_type' => true,
            ];
        } elseif ($section['section_slug'] == 'assessments') {
            $formattedData[] = [
                'section_id' => $section->id,
                'section_title' => $section->section_title,
                'section_slug' => $section->section_slug,
                'section_text' => $section_text,
                'id_default' => (int) $section->sorting_order,
                'fixed_id' => 69,
            ];
        } elseif ($section['section_slug'] == 'mental_status_examination') {
            $formattedData[] = [
                'section_id' => $section->id,
                'section_title' => $section->section_title,
                'section_slug' => $section->section_slug,
                'section_text' => $section_text,
                'id_default' => 100,
                'fixed_id_mental' => 71,
            ];
        } else {
            $formattedSection = [
                'section_id' => $section->id,
                'section_title' => $section->section_title,
                'section_slug' => $section->section_slug,
                'section_text' => $section_text,
                'id_default' => (int) $section->sorting_order,
            ];

            $formattedData[] = $formattedSection;
        }
    }
@endphp
    <!DOCTYPE html>
<html lang="en">

<head>
    <title>{{ $patient->first_name }} {{ $patient->last_name }}</title>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>

    <!-- Bootstrap CSS v5.3.2 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous"/>
    <style type="text/css">
        * {
            margin: 0;
            padding: 0;
            text-indent: 0;
        }

        h1 {
            color: black;
            font-family: "Trebuchet MS", sans-serif;
            font-style: normal;
            font-weight: bold;
            text-decoration: none;
            font-size: 14pt;
        }

        p {
            color: black;
            font-family: "Trebuchet MS", sans-serif;
            font-style: normal;
            font-weight: normal;
            text-decoration: none;
            font-size: 12pt;
            margin: 0;
        }

        li {
            display: block;
        }

        #l1 {
            padding-left: 0;
        }

        #l1 > li > *:first-child:before {
            content: "- ";
            color: black;
            font-family: "Trebuchet MS", sans-serif;
            font-style: normal;
            font-weight: normal;
            text-decoration: none;
        }

        .page-break {
            page-break-before: always;
        }

        @page {
            margin: 20mm;
            @top-center {
                content: "";
                border-bottom: 1px solid black;
            }
        }

        .header-content {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: 2cm;
            text-align: center;
            font-size: 12pt;
        }

        .page-number {
            text-align: center;
            font-size: 11pt;
            position: fixed;
            bottom: 10mm;
            width: 100%;
        }

        .container {
            margin-top: 2.5cm; /* Adjust this value to avoid overlapping with header */
        }
    </style>
</head>

<body>
<div class="header-content">
    <header>
        <img src="{{ asset('assets/admin/images/logo-blue-latest.png') }}" style="width:20%" alt="">
        <ul class="list-group list-group-flush float-end">
            <li class="list-group-item border-0">Eileen Murphy-Sinclair FNP-C</li>
            <li class="list-group-item border-0">NPI# 1598536906</li>
            <li class="list-group-item border-0">Soul Housing</li>
            <li class="list-group-item border-0">145 S. Fairfax Ave, Suite 200,</li>
            <li class="list-group-item border-0">Los Angeles, CA 90036</li>
        </ul>
    </header>
</div>

<div class="container">
    <main>
        @foreach ($formattedData as $item)
            @if ($item['section_slug'] == 'review-of-systems' || $item['section_slug'] == 'physical-exam')
                @if (!$loop->first)
                    <div class="page-break"></div>
                @endif
                <h1>{{ $item['section_title'] }}:</h1>
                <p>{!! $item['section_text'] !!}</p>
                @if ($item['section_slug'] == 'physical-exam')
                    <div class="page-break"></div>
                @endif
            @else
                <h1>{{ $item['section_title'] }}:</h1>
                <p>{!! $item['section_text'] !!}</p>
            @endif
        @endforeach

        <p><br/></p>
        <h1>VISIT CODES:</h1>
        <p>99345; Home/res Visit New Patient 99349 Home Visit Established</p>
    </main>

    <footer class="page-number">
        Page: <span class="page-number"></span>
    </footer>
</div>

<script type="text/php">
    $pdf->page_script(function ($pageNumber, $pageCount, $fontMetrics) {
        $font = $fontMetrics->get_font("Arial, Helvetica, sans-serif", "normal");
        $size = 12;
        $pageText = "Page " . $pageNumber . " of " . $pageCount;
        $y = 15;
        $x = 520;
        $page->text($x, $y, $pageText, $font, $size);
    });
</script>

<!-- Bootstrap JavaScript Libraries -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous">
</script>
</body>

</html>
