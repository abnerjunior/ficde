<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;


  /**
 * @OA\Schema(
 *   schema="semestres",
 *   type="object",
 *   @OA\Property(
 *       property="nombre",
 *       type="string",
 *       required={"true"},
 *       description="The semestres nombre"
 *   ),
 *   @OA\Property(
 *       property="fecha_inicio",
 *       type="string",
 *       required={"true"},
 *       description="The semestres fecha"
 *   ),
 *   @OA\Property(
 *       property="fecha_final",
 *       type="string",
 *       required={"true"},
 *       description="The semestres fecha"
 *   ),
 *    @OA\Property(
 *       property="status",
 *       type="string",
 *       required={"true"},
 *       description="The asistencias telefono"
 *   ),
 * @OA\Property(
 *       property="user_r",
 *       type="string",
 *       required={"true"},
 *       description="The aulas user_r"
 *   ),
 * )
 */

class semestres extends Base
{
    protected $table = 'semestres';
    protected $primaryKey = 'cod_semestre';
      
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre',
        'fecha_inicio',
        'fecha_final',
        'status',
        'user_r'
    ];
    /**
     * The attributes that are filterable.
     *
     * @var array
     */
    public static $filterable = [
        'cod_semestre',
        'nombre'
    ];
}
