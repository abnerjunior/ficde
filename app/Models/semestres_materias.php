<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

/**
 * @OA\Schema(
 *   schema="semestres_materias",
 *   type="object",
 *   @OA\Property(
 *       property="id_materia",
 *       type="string",
 *       required={"true"},
 *       description="The Estudiantes id_materia"
 *   ),
 *   @OA\Property(
 *       property="id_semestres",
 *       type="string",
 *       required={"true"},
 *       description="The Estudiantes id_semestres"
 *   ),
 *   @OA\Property(
 *       property="id_usuario",
 *       type="string",
 *       required={"true"},
 *       description="The Estudiantes id_usuario"
 *   ),
 *   @OA\Property(
 *       property="id_aula",
 *       required={"true"},
 *       type="string",
 *       description="The Estudiantes id_aula"
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

class semestres_materias extends Base
{
    protected $table = 'semestres_materias';
      
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_materia',
        'id_semestres',
        'id_usuario',
        'id_aula',
        'status',
        'user_r'
    ];
    /**
     * The attributes that are filterable.
     *
     * @var array
     */
    public static $filterable = [
        'cod_sm',
        'id_semestres',
        'id_usuario',
        'id_aula'
    ];
}
