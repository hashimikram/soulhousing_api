<?php

use Illuminate\Support\Carbon;
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
