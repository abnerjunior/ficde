<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

/**
 * @OA\Schema(
 *   schema="estudiantes_materias",
 *   type="object",
 *   @OA\Property(
 *       property="id_semestre",
 *       type="string",
 *       required={"true"},
 *       description="The Estudiantes id_semestre"
 *   ),
 *   @OA\Property(
 *       property="id_turno",
 *       type="string",
 *       required={"true"},
 *       description="The Estudiantes id_turno"
 *   ),
 *   @OA\Property(
 *       property="id_modalidad",
 *       type="string",
 *       required={"true"},
 *       description="The Estudiantes id_modalidad"
 *   ),
 *   @OA\Property(
 *       property="id_estudiante",
 *       required={"true"},
 *       type="string",
 *       description="The Estudiantes id_estudiante"
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

class estudiantes_materias extends Base
{
    protected $table = 'estudiantes_materias';
    protected $primaryKey = 'cod_em';
      
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_semestre',
        'id_turno',
        'id_modalidad',
        'id_estudiante',
        'status',
        'user_r'
    ];
    /**
     * The attributes that are filterable.
     *
     * @var array
     */
    public static $filterable = [
        'cod_em',
        'id_semestre',
        'id_estudiante'
    ];
}
