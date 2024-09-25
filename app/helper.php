<?php

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Stevebauman\Location\Facades\Location;

function apiSuccess($data = [], $statusCode = 200)
{
    return response()->json([
        'success' => true,
        'data' => $data
    ], $statusCode);
}

function apiError($message = [], $statusCode)
{
    return response()->json([
        'success' => false,
        'error' => $message
    ], $statusCode);
}

function formatFileSize($bytes, $decimals = 2)
{
    $size = ['B', 'KB', 'MB', 'GB', 'TB'];

    $factor = floor((strlen($bytes) - 1) / 3);

    return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . ' ' . @$size[$factor];
}

if (!function_exists('getUserTimeWithTimezone')) {
    /**
     * Get the current date and time formatted in the user's timezone based on their IP address.
     *
     * @return string
     */
    function getUserTimeWithTimezone()
    {
        // Get the user's IP address
        $ip = request()->ip();

        // Use the Location facade to get location data
        $position = Location::get($ip);
        $timezone = $position->timezone ?? 'UTC';
        // Fallback timezone if API call fails
        if (!$timezone) {
            $timezone = 'UTC';  // Default timezone
        }

        // Set the current timestamp with the fetched timezone
        $currentTimestamp = Carbon::now($timezone);

        // Format the timestamp in 12-hour format with AM/PM
        return $currentTimestamp->format('Y-m-d h:i:s A');
    }
}

function Unauthorized()
{
    if (!auth()->check()) {
        return redirect()->back()->with('error', 'Unauthorized');
    }
}

if (!function_exists('formatDate')) {

    function formatDate($date, $format = 'Y-M-d')
    {
        return \Carbon\Carbon::parse($date)->format($format);
    }
}

if (!function_exists('image_url')) {

    function image_url($imagePath)
    {
        return env('ASSET_URL') . 'uploads/' . $imagePath;
    }
}

if (!function_exists('check_id')) {
    function check_id($id)
    {
        if (!is_numeric($id) || $id <= 0) {
            return redirect()->back()->with('error', 'Id Invalid');
        }
    }
}

if (!function_exists('current_facility')) {
    function current_facility($user_id)
    {
        $facility = DB::table('personal_access_tokens')->where(
            'tokenable_id',
            $user_id
        )->latest()->first();
        return $facility->current_facility ?? null;
    }
}

if (!function_exists('physical_exam_text')) {
    function physical_exam_text()
    {
        return  "Appearance: Well-nourished, well-developed, no acute distress.
        Skin: Warm, dry, intact, no rashes or lesions.
        Head: Normocephalic, atraumatic.
        Eyes: PERRLA (Pupils Equal, Round, Reactive to Light and Accommodation), EOMI (Extraocular Movements Intact), sclerae white, conjunctivae pink.
        Ears: Tympanic membranes intact, no erythema or discharge.
        Nose: Mucosa pink, no discharge, septum midline.
        Mouth/Throat: Mucosa pink, no lesions, tonsils absent or not enlarged, uvula midline.
        Neck: No lymphadenopathy, thyroid non-palpable, trachea midline.
        Chest/Lungs: Clear to auscultation bilaterally, no wheezes, rales, or rhonchi.
        Heart: Regular rate and rhythm, no murmurs, gallops, or rubs.
        Abdomen: Soft, non-tender, no masses or organomegaly, bowel sounds normal.
        Genitourinary: No costovertebral angle tenderness.
        Musculoskeletal: Full range of motion, no joint swelling or deformity.
        Neurological: Alert and oriented x3, cranial nerves II-XII intact, motor strength 5/5, sensation intact, reflexes 2+ and symmetric.
        Psychiatric: Appropriate affect and behavior, normal mood and cognition, speech clear and coherent.";
    }
}

if (!function_exists('review_of_symstem_text')) {
    function review_of_symstem_text()
    {
        return  "General: Denies weight loss, weight gain, or fatigue. Denies fever, chills, or night sweats.
            Skin: Denies rashes, itching, or changes in moles.
            Head: Denies headaches, dizziness, or trauma.
            Eyes: Denies vision changes, pain, redness, or discharge.
            Ears: Denies hearing loss, pain, tinnitus, or discharge.
            Nose: Denies congestion, discharge, nosebleeds, or sinus pain.
            Mouth/Throat: Denies sore throat, difficulty swallowing, or hoarseness.
            Neck: Denies lumps, pain, or stiffness.
            Breasts/Chest: Denies lumps, pain, or discharge.
            Respiratory: Denies cough, shortness of breath, or wheezing.
            Cardiovascular: Denies chest pain, palpitations, or edema.
            Gastrointestinal: Denies nausea, vomiting, diarrhea, or constipation.
            Genitourinary: Denies frequency, urgency, dysuria, or hematuria.
            Musculoskeletal: Denies joint pain, stiffness, or muscle weakness.
            Neurological: Denies numbness, tingling, weakness, or seizures.
            Psychiatric: Denies anxiety, depression, or sleep disturbances.
            Endocrine: Denies polyuria, polydipsia, or heat/cold intolerance.
            Hematologic/Lymphatic: Denies easy bruising, bleeding, or swollen glands.
            Allergic/Immunologic: Denies allergies, frequent infections, or immunodeficiency.";
    }
}
