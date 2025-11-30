<?php

use Illuminate\Http\JsonResponse;

if (! function_exists('successResponse')) {
    function successResponse($data = [], $message = 'Success', $statusCode = 200, $headers = [], $options = 0): JsonResponse
    {
        $content = [
            'success' => true,
            'message' => $message,
        ];
        if (! empty($data)) {
            $content['data'] = $data;
        }

        return response()->json($content, $statusCode, $headers, $options);
    }
}

if (! function_exists('errorResponse')) {
    function errorResponse($message = 'Error', $statusCode = 400, $headers = [], $options = 0): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $message,
        ], $statusCode, $headers, $options);
    }
}
