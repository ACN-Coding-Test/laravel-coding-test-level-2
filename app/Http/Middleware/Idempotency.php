<?php

namespace App\Http\Middleware;

use Closure;
use Cache;
use Illuminate\Http\Request;
use Carbon\Carbon;

class Idempotency
{
    const IDEMPOTENCY_HEADER = 'Idempotency-Key';
    const IDEMPOTENCY_EXPIRATION = 1; // in minutes

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if($request->hasHeader(self::IDEMPOTENCY_HEADER)){
            $requestID = $request->header(self::IDEMPOTENCY_HEADER);

            if (!Cache::has($requestID) || env('APP_ENV') == "local") {

                // collect response from the request and cache it
                $response = $next($request);
                $response->header(self::IDEMPOTENCY_HEADER,$requestID);
                $response->header("Is-Replay","false");


                if($response->status() == 200) // if its not an error, cache it
                Cache::put($requestID, [
                    "response" => $response->getContent(),
                    "path" => $request->path(),
                    "status" => $response->status()
                ], Carbon::now()->addMinutes(self::IDEMPOTENCY_EXPIRATION));
                return $response;
            } else {
                $responseFromCache = Cache::get($requestID);
                if($request->path() ==  $responseFromCache["path"]){
                    // respond from cache
                    return response($responseFromCache["response"],$responseFromCache["status"])->withHeaders([
                        self::IDEMPOTENCY_HEADER => $requestID,
                        "Is-Replay" => "true",
                        "Content-Type" => "application/json"
                    ]);
                } else {
                    // reject request because idempotency key is the same and path isn't
                    return response(
                        [
                            "message" =>  self::IDEMPOTENCY_HEADER . " key is the same and endpoint is different."
                        ],400);
                }

            }

        } else {
            // reject request because idempotency key doesn't exist
            return response(
                [
                    "message" =>  self::IDEMPOTENCY_HEADER . " header doesn't exist."
                ],400);
        }
    }

}
