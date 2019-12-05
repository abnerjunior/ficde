<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;

/**
 * @OA\Info(
 *   version="1.0.0",
 *   title="Swagger-demo",
 *   description="Swagger `Api of condominiums`",
 *   @OA\Contact(
 *       email="swagger@gmail.com"
 *   )
 * )
 * @OA\Server(url="http://localhost:8000/condominiums")
 * @OA\Server(url="https://swagger-demo-style.herokuapp.com/condominiums")
 */

class Controller extends BaseController
{
    //
}
