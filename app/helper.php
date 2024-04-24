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
