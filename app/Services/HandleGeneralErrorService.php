<?php

namespace App\Services;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class HandleGeneralErrorService
{
    public function log(\Throwable|\Exception $error): JsonResponse
    {
        try {

            Log::error($error);

            return response()->json([
                'success' => false,
                'message' => 'Internal Server Error',
            ], Response::HTTP_INTERNAL_SERVER_ERROR);

        } catch (\Throwable|\Exception $e) {

            Log::error($e);

            return response()->json([
                'success' => false,
                'message' => 'Internal Server Error',
            ], Response::HTTP_INTERNAL_SERVER_ERROR);

        }

    }
}
