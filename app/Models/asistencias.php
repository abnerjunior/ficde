<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class asistencias extends Model
{
     /**
 * @OA\Schema(
 *   schema="Institucion",
 *   type="object",
 *   @OA\Property(
 *       property="name",
 *       type="string",
 *       required={"true"},
 *       description="The Institucion name"
 *   ),
 *   @OA\Property(
 *       property="lastname",
 *       type="string",
 *       required={"true"},
 *       description="The Institucion lastname"
 *   ),
 *   @OA\Property(
 *       property="documents",
 *       type="string",
 *       required={"true"},
 *       description="The Institucion documents"
 *   ),
 *   @OA\Property(
 *       property="email",
 *       required={"true"},
 *       type="string",
 *       description="The Institucions email"
 *   ),
 *   @OA\Property(
 *       property="phone",
 *       type="string",
 *       required={"true"},
 *       description="The Institucions phone"
 *   ),
 *   @OA\Property(
 *       property="password",
 *       type="string",
 *       required={"true"},
 *       description="The Institucions password"
 *   ),
 * )
 */
}
