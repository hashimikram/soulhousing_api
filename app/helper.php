<?php

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
