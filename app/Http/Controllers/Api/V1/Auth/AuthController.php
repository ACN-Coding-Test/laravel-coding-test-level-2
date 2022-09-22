<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use JWTAuth;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Exception;

class AuthController extends Controller
{
    # Invalid Login Response #
    public function invalidLogin()
    {
        return response()->json([
            'status' => Response::HTTP_UNAUTHORIZED,
            'message' => "Token Missmatch"
        ], Response::HTTP_UNAUTHORIZED);
    }

    # Issued Token Response #
    protected function respondWithToken($token)
    {
        return response()->json([
            'status' => Response::HTTP_OK,
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => JWTAuth::factory()->getTTL() * 300 # expired in 5 hours
        ], Response::HTTP_OK);
    }

    /**
     * @OA\Post(
     * path="/login",
     * summary="Login",
     * operationId="authLogin",
     * tags={"Authentication"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Login",
     *    @OA\JsonContent(
     *       required={"username","password"},
     *       @OA\Property(property="username", type="string", format="text", example="admin"),
     *       @OA\Property(property="password", type="string", format="password", example="admin"),
     *    ),
     * ),
     *   @OA\Response(
     *        response=200,
     *        description="Successful operation",
     *     ),
     *  @OA\Response(
     *        response=400,
     *        description="Bad Request",
     *    ),
     *    @OA\Response(
     *        response=401,
     *        description="Unauthorized",
     *    ),
     *    @OA\Response(
     *        response=403,
     *        description="Forbidden"
     *    ),
     *    @OA\Response(
     *        response=500,
     *        description="Internal Server Error",
     *    )
     * )
    */
    public function login(Request $request)
    {
        try {
            # Validation Rules #
            $credentials = $request->only('username','password');
            $validator = Validator::make($credentials, [
                'username' => 'required|string|min:3|max:50',
                'password' => 'required|string|min:3|max:100',
            ]);
    
            # Cred Validation #
            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors(), 'status' => Response::HTTP_BAD_REQUEST], Response::HTTP_BAD_REQUEST);
            }

            # Token Issued #
            if ($token = JWTAuth::attempt($credentials)) {
                return $this->respondWithToken($token);
            }
    
            return response()->json([
                'status' => Response::HTTP_UNAUTHORIZED,
                'message' => "user not found"
            ], Response::HTTP_UNAUTHORIZED);
            
        } catch (Exception $e) {
            return response()->json([
                'status' => Response::HTTP_BAD_REQUEST,
                'message' => $e->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }

    }
    
}
