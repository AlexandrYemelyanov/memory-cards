<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait AppResponse
{
    protected function responseJson($message, $code = 200, $options = []): JsonResponse
    {
        $data = [
            'message' => $message,
            'status' => $code
        ];

        $data = array_merge($data, ['options' => $options]);

        return response()->json($data);
    }
}
