<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class notas extends Model
{
     /**
 * @OA\Schema(
 *   schema="Notas",
 *   type="object",
 *   @OA\Property(
 *       property="name",
 *       type="string",
 *       required={"true"},
 *       description="The Notas name"
 *   ),
 *   @OA\Property(
 *       property="lastname",
 *       type="string",
 *       required={"true"},
 *       description="The Notas lastname"
 *   ),
 *   @OA\Property(
 *       property="documents",
 *       type="string",
 *       required={"true"},
 *       description="The Notas documents"
 *   ),
 *   @OA\Property(
 *       property="email",
 *       required={"true"},
 *       type="string",
 *       description="The Notass email"
 *   ),
 *   @OA\Property(
 *       property="phone",
 *       type="string",
 *       required={"true"},
 *       description="The Notass phone"
 *   ),
 *   @OA\Property(
 *       property="password",
 *       type="string",
 *       required={"true"},
 *       description="The Notass password"
 *   ),
 * )
 */
}
