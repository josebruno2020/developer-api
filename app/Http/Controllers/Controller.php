<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Routing\Controller as BaseController;
use phpDocumentor\Reflection\Types\Resource_;
use Symfony\Component\HttpFoundation\Response;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function sendMessage(string $message, array|JsonResource $content, int $code = Response::HTTP_OK): JsonResponse
    {
        return response()->json(['message' => $message, 'content' => $content], $code);
    }

    protected function sendError(string $errorMessage, int $code =  Response::HTTP_INTERNAL_SERVER_ERROR): JsonResponse
    {
        return response()->json(['error' => $errorMessage], $code);
    }
}
