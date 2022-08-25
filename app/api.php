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
 *     @OA\Parameter(name="Authorization", in="header", @OA\Schema(type="string"), required=true, description="JWT Token"),
 *     @OA\Parameter(name="sortBy", in="query", @OA\Schema(type="string"),  description="Sort Order"),
 *     @OA\Parameter(name="sortDirection", in="query", @OA\Schema(type="string", enum={"asc","desc"}),  description="Sort Direction"),
 *     @OA\Parameter(name="includes", in="query", description="Includes for getting object dependened data", @OA\Schema(type="array", @OA\Items( type="string", collectionFormat="csv")) )
 *    ),
 * )
 */

/**
 * @OA\Get(
 *     path="/projects",
 *     @OA\Response(response="200", description="Display a listing of projects.")
 * )
 */
