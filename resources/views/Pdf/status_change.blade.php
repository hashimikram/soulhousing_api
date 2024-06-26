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
   $sections = App\Models\EncounterNoteSection::where('encounter_id', $encounter_id)->orderBy('id', 'ASC')->get();

         $formattedData = [];
         foreach ($sections as $section) {
             $sectionText = null;
             if ($section->section_text !== null) {
                 $decodedText = json_decode($section->section_text, true);
                 if ($decodedText !== null) {
                     $sectionText = $decodedText;
                 } else {
                     $sectionText = $section->section_text;
                 }
             }

             // Initialize dataSection
             $dataSection = [];

             if ($section->section_title == 'Review of Systems') {
                 $reviewOfSystemDetails = App\Models\ReviewOfSystemDetail::where('section_id', $section->id)->get();
                 foreach ($reviewOfSystemDetails as $data) {
                     $sectionText = "General: {$data->general}\n" . "Skin: {$data->skin}\n" . "Head: {$data->head}\n" . "Eyes: {$data->eyes}\n" . "Ears: {$data->ears}\n" . "Nose: {$data->nose}\n" . "Mouth/Throat: {$data->mouth_throat}\n" . "Neck: {$data->neck}\n" . "Breasts: {$data->breasts}\n" . "Respiratory: {$data->respiratory}\n" . "cardiovascular: {$data->cardiovascular}\n" . "gastrointestinal: {$data->gastrointestinal}\n" . "Musculoskeletal: {$data->musculoskeletal}\n" . "Neurological: {$data->neurological}\n" . "Psychiatric: {$data->psychiatric}\n" . "Endocrine: {$data->endocrine}\n" . "Hematologic/Lymphatic: {$data->hematologic_lymphatic}\n" . "Allergic/Immunologic: {$data->allergic_immunologic}\n";
                 }
             } elseif ($section->section_title == 'Physical Exam') {
                 $physicalExamDetails = App\Models\PhysicalExamDetail::where('section_id', $section->id)->get();
                 foreach ($physicalExamDetails as $data) {
                     $sectionText = "General Appearance: {$data->general_appearance}\n" . "Skin: {$data->skin}\n" . "Head: {$data->head}\n" . "Eyes: {$data->eyes}\n" . "Ears: {$data->ears}\n" . "Nose: {$data->nose}\n" . "Mouth/Throat: {$data->mouth_throat}\n" . "Neck: {$data->neck}\n" . "Chest/Lungs: {$data->chest_lungs}\n" . "Cardiovascular: {$data->cardiovascular}\n" . "Abdomen: {$data->abdomen}\n" . "Genitourinary: {$data->genitourinary}\n" . "Musculoskeletal: {$data->musculoskeletal}\n" . "Neurological: {$data->neurological}\n" . "Psychiatric: {$data->psychiatric}\n" . "Endocrine: {$data->endocrine}\n" . "Hematologic/Lymphatic: {$data->hematologic_lymphatic}\n" . "Allergic/Immunologic: {$data->allergic_immunologic}\n";
                 }
             } elseif ($section->section_title == 'ASSESSMENTS/CARE PLAN') {
                 $problems = App\Models\Problem::where('patient_id', $section->patient_id)
                     ->where('provider_id', auth()->user()->id)
                     ->get();

                 $sectionText = ''; // Initialize an empty string to accumulate all section text

                 foreach ($problems as $data) {
                     $sectionText .= "Code: {$data->diagnosis}\n" . "Description: {$data->name}\n";
                 }
             } elseif ($section->section_title == 'Vital Sign') {
                 // Retrieve the latest vital record for the patient and provider
                 $latestVital = App\Models\Vital::where('patient_id', $section->patient_id)
                 ->where('provider_id', auth()->user()->id)
                 ->orderBy('created_at', 'desc')
                 ->select(
                     'weight_lbs',
                     'weight_oz',
                     'weight_kg',
                     'height_ft',
                     'height_in',
                     'height_cm',
                     'bmi_kg',
                     'bmi_in',
                     'bsa_cm2',
                     'waist_cm',
                     'systolic',
                     'diastolic',
                     'position',
                     'cuff_size',
                     'cuff_location',
                     'cuff_time',
                     'fasting',
                     'postprandial',
                     'fasting_blood_sugar',
                     'blood_sugar_time',
                     'pulse_result',
                     'pulse_rhythm',
                     'pulse_time',
                     'body_temp_result_f',
                     'body_temp_result_c',
                     'body_temp_method',
                     'body_temp_time',
                     'respiration_result',
                     'respiration_pattern',
                     'respiration_time',
                     'saturation',
                     'oxygenation_method',
                     'device',
                     'oxygen_source_1',
                     'oxygenation_time_1',
                     'inhaled_o2_concentration',
                     'oxygen_flow',
                     'oxygen_source_2',
                     'oxygenation_time_2',
                     'peak_flow',
                     'oxygenation_time_3',
                     'office_test_oxygen_source_1',
                     'office_test_date_1',
                     'office_test_oxygen_source_2',
                     'office_test_date_2',
                     'pulse_beats_in',
                     'resp_rate',
                     'head_in',
                     'waist_in',
                     'glucose'
                 )
                 ->first();


                 $sectionText = ''; // Initialize an empty string to accumulate the section text

                 if ($latestVital) {
                     // Get all column names from the 'vitals' table
                     $columns = Schema::getColumnListing('vitals');

                     foreach ($columns as $column) {
                         if (!is_null($latestVital->$column)) {
                             $label = ucwords(str_replace('_', ' ', $column));
                             $sectionText .= "{$label}: {$latestVital->$column}\n";
                         }
                     }
                 }

                 // Output or use the $sectionText as needed
             }
             $formattedData[] = [
                 'section_id' => $section->id,
                 'section_title' => $section->section_title,
                 'section_slug' => $section->section_slug,
                 'section_text' => $sectionText,
                 'id_default' => (int) $section->id_default,
             ];
         }

@endphp
<div class="container mt-5">
    <header>
        <img src="{{ asset('public/ri_1.png') }}" alt=""/>
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
            <li class="list-group-item border-0">Date</li>
            <li class="list-group-item border-0">DOB</li>
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
                {!! nl2br(e($item['section_text'])) !!}
            </p>
        @endforeach


        <h1 style="padding-left: 5pt; text-indent: 0pt; text-align: left">
            Follow Up:
        </h1>
        <p style="text-indent: 0pt; text-align: left"><br/></p>
        <ul id="l1">
            <li data-list-text="-">
                <p
                    style="
                padding-left: 35pt;
                text-indent: -30pt;
                line-height: 13pt;
                text-align: left;
              ">
                    Follow Up with PCP for Further Medical Management
                </p>
            </li>
            <li data-list-text="-">
                <p
                    style="
                padding-left: 35pt;
                text-indent: -30pt;
                line-height: 13pt;
                text-align: justify;
              ">
                    Follow Up with Psychiatrist
                </p>
            </li>
        </ul>
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
