<?php
namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait CardResponse
{
    private function responseJson($message, $code = 200, $options = []): JsonResponse
    {
        $data = [
            'message' => $message,
            'status' => $code
        ];

        $data = array_merge($data, $options);

        return response()->json($data);
    }
}
