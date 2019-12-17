<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;


  /**
 * @OA\Schema(
 *   schema="notas",
 *   type="object",
 *   @OA\Property(
 *       property="nota",
 *       type="string",
 *       required={"true"},
 *       description="The Estudiantes nota"
 *   ),
 *   @OA\Property(
 *       property="id_em",
 *       type="string",
 *       required={"true"},
 *       description="The Estudiantes id_sm"
 *   ),
 *   @OA\Property(
 *       property="id_estudiante",
 *       type="string",
 *       required={"true"},
 *       description="The Estudiantes id_estudiante"
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

class notas extends Base
{
    protected $table = 'notas';
    protected $primaryKey = 'cod_nota';
      
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nota',
        'id_em',
        'id_estudiante',
        'status',
        'user'
    ];
    /**
     * The attributes that are filterable.
     *
     * @var array
     */
    public static $filterable = [
        'id_sm',
        'id_estudiante',
        'cod_nota'
    ];
}
