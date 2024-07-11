<!DOCTYPE html>
<html lang="en">

<head>
    <title>Title</title>
    <!-- Required meta tags -->
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>

    <!-- Bootstrap CSS v5.2.1 -->
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
            font-size: 11pt;
        }

        .p,
        p {
            color: black;
            font-family: "Trebuchet MS", sans-serif;
            font-style: normal;
            font-weight: normal;
            text-decoration: none;
            font-size: 11pt;
            margin: 0pt;
        }

        li {
            display: block;
        }

        #l1 {
            padding-left: 0pt;
        }

        #l1 > li > *:first-child:before {
            content: "- ";
            color: black;
            font-family: "Trebuchet MS", sans-serif;
            font-style: normal;
            font-weight: normal;
            text-decoration: none;
        }
    </style>
</head>

<body>
@php
    $formattedData = [];
            $sections = \App\Models\EncounterNoteSection::where('encounter_id', $encounter_id)->orderBy('id', 'ASC')->get();
                $patient_id = $sections->first()->patient_id;
    $patient = \App\Models\Patient::where('id', $patient_id)->first();
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
                if ($section['section_slug'] == 'wound_evaluation') {
                    $formattedData[] = [
                        'section_id' => $section->id,
                        'section_title' => $section->section_title,
                        'section_slug' => $section->section_slug,
                        'section_text' => $section->section_text ?? '',
                        'id_default' => (int) $section->sorting_order,
                        'section_type' => true,
                    ];
                } elseif ($section['section_slug'] == 'assessments') {
                    $formattedData[] = [
                        'section_id' => $section->id,
                        'section_title' => $section->section_title,
                        'section_slug' => $section->section_slug,
                        'section_text' => $section->section_text ?? '',
                        'id_default' => (int) $section->sorting_order,
                        'fixed_id' => 69,
                    ];
                } elseif ($section['section_slug'] == 'mental_status_examination') {
                    $formattedData[] = [
                        'section_id' => $section->id,
                        'section_title' => $section->section_title,
                        'section_slug' => $section->section_slug,
                        'section_text' => $section->section_text ?? '',
                        'id_default' => 100,
                        'fixed_id_mental' => 71,
                    ];
                } else {
                    $formattedSection = [
                        'section_id' => $section->id,
                        'section_title' => $section->section_title,
                        'section_slug' => $section->section_slug,
                        'section_text' => $section->section_text ?? '',
                        'id_default' => (int) $section->sorting_order,
                    ];

                    $formattedData[] = $formattedSection;
                }


            }

@endphp
<div class="container" style="margin-top: 100px;">
    <header>
        <img src="{{asset('assets/admin/images/logo-blue-latest.png')}}" style="width:20%" alt="">

        <ul class="list-group list-group-flush float-end">
            <li class="list-group-item border-0">Eileen Murphy-Sinclair FNP-C</li>
            <li class="list-group-item border-0">NPI# 1598536906</li>
            <li class="list-group-item border-0">Soul Housing</li>
            <li class="list-group-item border-0">
                145 S. Fairfax Ave, Suite 200,
            </li>
            <li class="list-group-item border-0">Los Angeles, CA 90036</li>
        </ul>
    </header>
    <main class="mt-5">
        <ul class="list-group list-group-flush" style="font-weight: 700">
            <li class="list-group-item border-0">Name: {{ $name }}</li>
            <li class="list-group-item border-0">Date: {{\Carbon\Carbon::now()->format('d-M-Y')}}</li>
            <li class="list-group-item border-0">DOB: {{date('d-M-Y', strtotime($patient->date_of_birth))}}</li>
            <li class="list-group-item border-0">H.T</li>
            <li class="list-group-item border-0">W.T</li>
        </ul>
        @foreach ($formattedData as $item)
            <p style="padding-top: 12pt; text-indent: 0pt; text-align: left">
                <br/>
            </p>
            <h1 style="padding-left: 5pt; text-indent: 0pt; text-align: left">
                {{ $item['section_title'] }}:
            </h1>
            <p
                style="
      padding-left: 5pt;
      text-indent: 0pt;
      line-height: 200%;
      text-align: left;
    ">
                {!! $item['section_text']!!}
            </p>
        @endforeach
        <p style="text-indent: 0pt; text-align: left"><br/></p>
        <h1
            style="
            padding-left: 5pt;
            text-indent: 0pt;
            line-height: 13pt;
            text-align: justify;
          ">
            VISIT CODES:
        </h1>
        <p style="padding-left: 5pt; text-indent: 0pt; text-align: left">
            99345; Home/res Visit New Patient 99349 Home Visit Established
        </p>
    </main>

    <footer>
        <!-- place footer here -->
    </footer>
</div>

<!-- Bootstrap JavaScript Libraries -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous">
</script>
</body>

</html>


