<?php

namespace App\ApiHelper;

class ApiResponseHelper
{
    public static function sendResponse(Result $result, int $statusCode = ApiResponseCodes::SUCCESS)
    {
        return \Response::json([
            'success' => $result->isOk,
            'message' => $result->message,
            'data' => $result->result ?? null,
        ], $statusCode);
    }

    public static function sendResponseWithPagination(Result $response)
    {
        return \Response::json([
            'success' => $response->isOk,
            'message' => $response->message,
            'pagination' => $response->paginate ?? null,
            'data' => $response->result ?? null,
        ], ApiResponseCodes::SUCCESS);
    }
    public static function sendMessageResponse($message, $code = 200, $success = true)
    {
        return \Response::json([
            'success' => $success,
            'message' => $message,
        ], $code);
    }




}
