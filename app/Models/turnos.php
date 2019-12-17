<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

  /**
 * @OA\Schema(
 *   schema="turnos",
 *   type="object",
 *   @OA\Property(
 *       property="turno",
 *       type="string",
 *       required={"true"},
 *       description="The Turnos name"
 *   ),
 *   @OA\Property(
 *       property="hora",
 *       type="string",
 *       required={"true"},
 *       description="The Turnoss password"
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

class turnos extends Base
{
    protected $table = 'turnos';
    protected $primaryKey = 'cod_turno';

      
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'turno',
        'hora',
        'status',
        'user'
    ];
    /**
     * The attributes that are filterable.
     *
     * @var array
     */
    public static $filterable = [
        'cod_turno',
        'turno'
    ];
}
