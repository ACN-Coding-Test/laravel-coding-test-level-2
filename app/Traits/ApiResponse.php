<?php
namespace App\Traits;


trait ApiResponse {
    public function success($data, $message = 'Operation success', $code = 200)
    {
        return response()->json([
            'status' => true,
            'message' => $message,
            'data' => $data
        ], $code);
    }

    public function error($message, $code = 500)
    {
        return response()->json([
            'status' => false,
            'message' => $message,
        ], $code);
    }
}
