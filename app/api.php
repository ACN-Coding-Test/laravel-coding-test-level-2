<?php
/**
 * @OA\OpenApi(
 *     @OA\Server(url=L5_SWAGGER_CONST_HOST),
 *     @OA\Info(
 *         version="1.0.0",
 *         title="Project API API",
 *         @OA\Contact(name="Hiren Shah", email="hiren@atyantik.com"),
 *         @OA\License(name="Properietary", url="https://atyantik.com")
 *     ),
 *     @OA\Components(
 *     @OA\Schema(
 *         schema="Error",
 *         @OA\Property(
 *             property="errorMessage",
 *             type="string"
 *         )
 *     ),
 *     @OA\Schema(
 *         schema="Success",
 *         type="object",
 *         @OA\Property(
 *             property="message",
 *             type="string"
 *         )
 *     ),
 *     @OA\Schema(
 *         schema="Pagination",
 *         @OA\Property(
 *             property="pagination",
 *             type="object",
 *             @OA\Property(property="total", type="integer", description="Total"),
 *             @OA\Property(property="count", type="integer", description="Count"),
 *             @OA\Property(property="pageSize", type="integer", description="Per Page"),
 *             @OA\Property(property="pageIndex", type="integer", description="Current Page"),
 *             @OA\Property(property="totalPages", type="integer", description="Total Page"),
 *             @OA\Property(
 *                property="links",
 *                type="object",
 *                @OA\Property(property="first", type="string", description="First Page"),
 *                @OA\Property(property="last", type="string", description="Last Page"),
 *                @OA\Property(property="current", type="string", description="Current Page"),
 *            )
 *         )
 *     ),
 *     @OA\Parameter(name="Authorization", in="header", @OA\Schema(type="string"), required=true, description="Sanctum Token"),
 *     @OA\Parameter(name="sortBy", in="query", @OA\Schema(type="string"),  description="Sort Order"),
 *     @OA\Parameter(name="sortDirection", in="query", @OA\Schema(type="string", enum={"asc","desc"}),  description="Sort Direction"),
 *     @OA\Parameter(name="includes", in="query", description="Includes for getting object dependened data", @OA\Schema(type="array", @OA\Items( type="string", collectionFormat="csv")) )
 *    ),
 * )
 */

/**
 * @OA\Post(
 *   path="/users/login",
 *   tags={"Login"},
 *   summary="Login as User",
 *   description="Login as User",
 *   requestBody={"$ref":"#/components/requestBodies/Login"},
 *   @OA\Response(
 *     response=200,
 *     description="successful operation",
 *     @OA\JsonContent(ref="#/components/schemas/Success")
 *   ),
 *   @OA\Response(response=400,  description="Invalid Order"),
 *   @OA\Response(response=401, description="Invalid Credential", @OA\JsonContent(ref="#/components/schemas/Error")),
 *   @OA\Response(response=403, description="Forbidden"),
 *   @OA\Response(response=404, description="Invalid Client Code"),
 *   @OA\Response(response=500, description="Internal Server Error")
 * )
 */

/**
 * @OA\Get(
 *      path="/users",
 *      security={{
 *          "sanctum":{}
 *      }}, 
 *      operationId="getUserList",
 *      tags={"Users"},
 *      summary="Get list of users",
 *      description="Returns list of users",
 *      @OA\Response(
 *          response=200,
 *          description="Successful operation",
 *          @OA\JsonContent(ref="#/components/schemas/UserResource")
 *       ),
 *      @OA\Response(
 *          response=401,
 *          description="Unauthenticated",
 *      ),
 *      @OA\Response(
 *          response=403,
 *          description="Forbidden"
 *      )
 *     )
 */

/**
 * @OA\Post(
 *      path="/users",
 *      operationId="storeUser",
 *      tags={"Users"},
 *      summary="Store new user",
 *      description="Returns user data",
 *      @OA\Parameter(
 *          name="name",
 *          in="query",
 *          required=true,
 *          @OA\Schema(
 *              type="string"
 *          )
 *      ),
 *  @OA\Parameter(
 *      name="email",
 *      in="query",
 *      required=true,
 *      @OA\Schema(
 *           type="string"
 *      )
 *   ),
 *   @OA\Parameter(
 *       name="mobile_number",
 *      in="query",
 *      required=true,
 *      @OA\Schema(
 *           type="integer"
 *      )
 *   ),
 *   @OA\Parameter(
 *      name="password",
 *      in="query",
 *      required=true,
 *      @OA\Schema(
 *           type="string"
 *      )
 *   ),
 *      @OA\Parameter(
 *      name="password_confirmation",
 *      in="query",
 *      required=true,
 *      @OA\Schema(
 *           type="string"
 *      )
 *   ),
 *      @OA\Response(
 *          response=201,
 *          description="Successful operation",
 *          @OA\JsonContent(ref="#/components/schemas/UserResource")
 *       ),
 *      @OA\Response(
 *          response=400,
 *          description="Bad Request"
 *      ),
 *      @OA\Response(
 *          response=401,
 *          description="Unauthenticated",
 *      ),
 *      @OA\Response(
 *          response=403,
 *          description="Forbidden"
 *      )
 * )
 */