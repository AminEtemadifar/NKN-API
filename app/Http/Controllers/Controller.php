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
 */

abstract class Controller
{

}

