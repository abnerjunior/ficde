<?php
namespace App\Models;
use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
  /**
 * @OA\Schema(
 *   schema="asistencias",
 *   type="object",
 *   @OA\Property(
 *       property="id_em",
 *       type="integer",
 *       required={"true"},
 *       description="The estudiante materia"
 *   ),
 *   @OA\Property(
 *       property="id_estudiante",
 *       type="integer",
 *       required={"true"},
 *       description="The estudiante"
 *   ),
 *   @OA\Property(
 *       property="estatus",
 *       type="boolean",
 *       required={"true"},
 *       description="The asistencias telefono"
 *   ),
 * )
 */
class asistencias extends Base
{
      protected $table = 'asistencias';
    protected $primaryKey = 'cod_asistencia';
      
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_em',
        'id_estudiante',
        'estatus'
    ];
    /**
     * The attributes that are filterable.
     *
     * @var array
     */
    public static $filterable = [
        'cod_asistencia',
        'id_estudiante'
       
    ];
}