<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

 /**
 * @OA\Schema(
 *   schema="modalidades",
 *   type="object",
 *   @OA\Property(
 *       property="modalidad",
 *       type="string",
 *       required={"true"},
 *       description="The modalidad name"
 *   ),
 *    @OA\Property(
 *       property="status",
 *       type="string",
 *       required={"true"},
 *       description="The asistencias telefono"
 *   ),
 * @OA\Property(
 *       property="user",
 *       type="string",
 *       required={"true"},
 *       description="The aulas user"
 *   ),
 * )
 */

class modalidades extends Base
{
    protected $table = 'modalidades';
    protected $primaryKey = 'cod_modalidad';

      
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'modalidad',
        'status',
        'user'
    ];
    /**
     * The attributes that are filterable.
     *
     * @var array
     */
    public static $filterable = [
        'cod_modalidad',
        'modalidad'
    ];
}
