<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

/**
 * @OA\Schema(
 *   schema="materias",
 *   type="object",
 *   @OA\Property(
 *       property="cod_curso",
 *       type="string",
 *       required={"true"},
 *       description="The materia name"
 *   ),
 * @OA\Property(
 *       property="materia",
 *       type="string",
 *       required={"true"},
 *       description="The materia nombre"
 *   ),
 * @OA\Property(
 *       property="descripcion",
 *       type="string",
 *       required={"true"},
 *       description="The materia descripcion"
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

class materias extends Base
{
    protected $table = 'materias';
    protected $primaryKey = 'cod_materia';

      
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'cod_curso',
        'materia',
        'descripcion',
        'status',
        'user_r'
    ];
    /**
     * The attributes that are filterable.
     *
     * @var array
     */
    public static $filterable = [
        'cod_materia',
        'cod_curso',
        'descripcion',
        'materia'
    ];
}
