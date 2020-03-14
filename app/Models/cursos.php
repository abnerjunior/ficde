<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

/**
 * @OA\Schema(
 *   schema="cursos",
 *   type="object",
 *   @OA\Property(
 *       property="curso",
 *       type="string",
 *       required={"true"},
 *       description="The curso name"
 *   ),
 * @OA\Property(
 *       property="descripcion",
 *       type="string",
 *       required={"true"},
 *       description="The curso descripcion"
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

class cursos extends Base
{
    protected $table = 'cursos';
    protected $primaryKey = 'cod_curso';

      
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'curso',
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
        'cod_curso',
        'curso'
    ];
    /**
     * Relationship
     */
    
    public function estudiantes()
    {
        return $this->belongsToMany(estudiantes::class, 'curso_estudiantes', 'id_curso', 'id_estudiante');
    }
}