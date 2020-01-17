<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;


  /**
 * @OA\Schema(
 *   schema="justificados",
 *   type="object",
 *   @OA\Property(
 *       property="tipo",
 *       type="string",
 *       required={"true"},
 *       description="The justificados tipo"
 *   ),
 *   @OA\Property(
 *       property="fecha",
 *       type="string",
 *       required={"true"},
 *       description="The justificados fecha"
 *   ),
 *   @OA\Property(
 *       property="id_asistencia",
 *       type="string",
 *       required={"true"},
 *       description="The justificados id_asistencia"
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


class justificados extends Base
{
    protected $table = 'justificados';
    protected $primaryKey = 'cod_justificado';
      
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'tipo',
        'fecha',
        'id_asistencia',
        'status',
        'user_r'
    ];
    /**
     * The attributes that are filterable.
     *
     * @var array
     */
    public static $filterable = [
        'id_asistencia',
        'cod_justificado'
    ];  
}