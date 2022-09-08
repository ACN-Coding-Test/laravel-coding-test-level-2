<?php
namespace App\Http\Traits;

use App\Http\Resources\ApiResource;

trait ResponseTrait{

    public static function sendResponse($data, $response_type, $message='',$status_code)
    {
        $response_data2 = ['code' => $response_type, 'message' => $message];

        $response = [
            'data'    => $data,
            'response' =>  $response_data2,
        ];

        return response()->json(new ApiResource($response), $status_code);
    }

}
