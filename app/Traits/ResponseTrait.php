<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait ResponseTrait
{
    private function getStatus(int $statusCode): string
    {
        $status = 'success';
        if ($statusCode >= 400) {
            $status = 'error';
        }
        return $status;
    }

    public function responseWithoutData(string $message, ?int $statusCode = 200): JsonResponse
    {
        return $this->baseResponse($statusCode, $message);
    }

    public function responseWithData(mixed $data, string $message, ?int $statusCode = 200)
    {
        return $this->baseResponse($data, $message, $statusCode);
    }

    /**
     * @param int|null $statusCode
     * @param string $message
     * @return JsonResponse
     */
    public function baseResponse(?int $statusCode, string $message): JsonResponse
    {
        return response()->json([
            'status' => $this->getStatus($statusCode),
            'message' => $message,
            'data' => [],
            'errors' => []
        ], $statusCode);
    }
}
