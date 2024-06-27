<?php

namespace App\Http\Responses;

class ApiResponse
{
    public static function success($data, $message = null, $statusCode = 200)
    {
        return response()->json([
            'status' => 'success',
            'data' => $data,
            'message' => $message
        ], $statusCode);
    }

    public static function error($message, $statusCode)
    {
        return response()->json([
            'status' => 'error',
            'message' => $message
        ], $statusCode);
    }
}
