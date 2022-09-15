<?php

namespace App\Http\Controllers;

class BaseController extends Controller
{
    public function sendResponse($message = null, $result = null, $code = 200)
    {
        $response = [
            'success' => true,
            'data'    => $result,
            'message' => $message,
        ];

        return response()->json($response, $code);
    }

    public function sendError($error, $errorMessages = [], $code = 500)
    {
        $response = [
            'success' => false,
            'message' => $error,
        ];

        if (!empty($errorMessages)) {
            $response['error'] = $errorMessages;
        }

        return response()->json($response, $code);
    }
}
