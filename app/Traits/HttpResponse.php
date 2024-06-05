<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait HttpResponse
{
    protected function success($data, int $statusCode = 200): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => $data,
            'message' => null,
        ], $statusCode);
    }

    protected function error(string $message, int $statusCode = 400): JsonResponse
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'data' => null
        ], $statusCode);
    }
}
