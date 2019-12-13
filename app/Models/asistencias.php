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
 *       property="nombre",
 *       type="string",
 *       required={"true"},
 *       description="The Institucion nombre"
 *   ),
 *   @OA\Property(
 *       property="registro",
 *       type="string",
 *       required={"true"},
 *       description="The asistencias registro"
 *   ),
 *   @OA\Property(
 *       property="telefono",
 *       type="string",
 *       required={"true"},
 *       description="The asistencias telefono"
 *   ),
 *   @OA\Property(
 *       property="direccion",
 *       type="string",
 *       required={"true"},
 *       description="The asistencias direccion"
 *   ),
 * )
 */
class asistencias extends Base
{
      protected $table = 'asistencias';
    protected $primaryKey = 'cod_institucion';
      
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre',
        'registro',
        'telefono',
        'direccion'
    ];
    /**
     * The attributes that are filterable.
     *
     * @var array
     */
    public static $filterable = [
        'cod_institucion',
        'nombre',
        'registro',
        'telefono',
        'direccion'
       
    ];
}