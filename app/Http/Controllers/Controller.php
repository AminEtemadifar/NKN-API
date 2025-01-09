<?php

namespace App\Http\Controllers;

/**
 * @OA\Info(
 *      version="1.0.0",
 *      title="Nikan website",
 *      description="Nikan website OpenApi Documentation",
 *      @OA\Contact(
 *          email="mifagroup2021@gmail.com
"
 *      ),
 * )
 * @OA\SecurityScheme(
 *      scheme="bearer",
 *      securityScheme="bearerAuth",
 *      type="http",
 *      description="Enter your Bearer token",
 *      in="header",
 *      bearerFormat="JWT",
 *  )
 * @OA\Server(
 *      url="http://127.0.0.1:8000/api",
 *      description="localhost"
 * ),
 * @OA\Server(
 *      url="https://api.mifadev.ir/api",
 *      description="staging"
 * )
 *
 * @OA\Schema(
 *      schema="LinksPaginationResource",
 *      title="LinksPaginationResource",
 *      type="object",
 *      description="links pagination resource",
 *      required={"first","last"},
 *      @OA\Xml(
 *           name="MetaPaginationResource"
 *       ),
 *      @OA\Property(
 *          property="first",
 *          type="string"
 *      ),
 *      @OA\Property(
 *          property="last",
 *          type="string"
 *      ),
 *      @OA\Property(
 *          property="prev",
 *          type="string"
 *      ),
 *      @OA\Property(
 *          property="next",
 *          type="string"
 *      ),
 * ),
 * @OA\Schema(
 *      schema="MetaPaginationResource",
 *      title="MetaPaginationResource",
 *      type="object",
 *      description="meta pagination resource",
 *      required={"current_page","from","last_page","links","path","per_page","to","total" },
 *      @OA\Xml(
 *           name="MetaPaginationResource"
 *       ),
 *      @OA\Property(
 *          property="current_page",
 *          type="integer"
 *      ),
 *      @OA\Property(
 *          property="from",
 *          type="integer"
 *      ),
 *      @OA\Property(
 *          property="last_page",
 *          type="integer"
 *      ),
 *      @OA\Property(
 *          property="links",
 *          type="array",
 *          @OA\Items(
 *              @OA\Property(
 *                  property="url",
 *                  type="string",
 *              ),
 *              @OA\Property(
 *                  property="label",
 *                  type="string",
 *              ),
 *              @OA\Property(
 *                  property="active",
 *                  type="boolean",
 *              ),
 *
 *          )
 *      ),
 *      @OA\Property(
 *          property="path",
 *          type="string"
 *      ),
 *      @OA\Property(
 *          property="per_page",
 *          type="integer"
 *      ),
 *      @OA\Property(
 *          property="to",
 *          type="integer"
 *      ),
 *      @OA\Property(
 *          property="total",
 *          type="integer"
 *      ),
 * ),
 */
abstract class Controller
{

}

