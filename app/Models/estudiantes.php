<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;


/**
 * @OA\Schema(
 *   schema="estudiantes",
 *   type="object",
 *   @OA\Property(
 *       property="nombre",
 *       type="string",
 *       required={"true"},
 *       description="The Estudiantes nombre"
 *   ),
 *   @OA\Property(
 *       property="apellido",
 *       type="string",
 *       required={"true"},
 *       description="The Estudiantes apellido"
 *   ),
 *   @OA\Property(
 *       property="dni",
 *       type="string",
 *       required={"true"},
 *       description="The Estudiantes dni"
 *   ),
 *   @OA\Property(
 *       property="email",
 *       required={"true"},
 *       type="string",
 *       description="The Estudiantes email"
 *   ),
 *   @OA\Property(
 *       property="telefono",
 *       type="string",
 *       required={"true"},
 *       description="The Estudiantes telefono"
 *   ),
 *   @OA\Property(
 *       property="direccion",
 *       type="string",
 *       required={"true"},
 *       description="The Estudiantes direccion"
 *   ),
 *   @OA\Property(
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

class estudiantes extends Base
{
    protected $table = 'estudiantes';
    
    protected $primaryKey = 'cod_estudiante';

    protected $incrementing=false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'dni',
        'nombre',
        'apellido',
        'email',
        'telefono',
        'direccion',
        'status',
        'user_r'
    ];
    /**
     * The attributes that are filterable.
     *
     * @var array
     */
    public static $filterable = [
        'cod_estudiante',
        'nombre',
        'apellido',
        'dni',
        'email'
    ];

    /**
     * Relationship
     */
    
    public function cursos()
    {
        return $this->belongsToMany(cursos::class, 'curso_estudiantes', 'id_estudiante', 'id_curso');
    }
}

