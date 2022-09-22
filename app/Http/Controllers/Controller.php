<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
    * @OA\Info(
    *      version="1.0.0",
    *      title="IT Business Solution - Laravel Test",
    *      description="Laravel Test Documentation",
    * )    
    * @OA\Server(
    *      url=L5_SWAGGER_CONST_HOST,
    *      description="Demo API Server"
    * )  

    * @OA\SecurityScheme(
    *     securityScheme="Bearer",
    *     bearerFormat="JWT",
    *     type="apiKey",
    *     in="header",
    *     name="Authorization"
    * )
*/
    
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
