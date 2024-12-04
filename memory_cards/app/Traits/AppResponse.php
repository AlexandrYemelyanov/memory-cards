<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait AppResponse
{
    /**
     * Return a custom JSON response.
     *
     * @param string $message The message to include in the response.
     * @param int $code The HTTP status code for the response.
     * @param array $options Additional options to include in the response.
     * @return JsonResponse The JSON response object.
     */
    protected function responseJson($message, $code = 200, $options = []): JsonResponse
    {
        $data = [
            'message' => $message,
            'status' => $code
        ];

        $data = array_merge($data, ['options' => $options]);

        return response()->json($data, $code);
    }
}
