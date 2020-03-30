<?php
namespace App\Models;
use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
/**
 * @OA\Schema(
 *   schema="sedes",
 *   type="object",
 * 
 *  *   @OA\Property(
 *       property="cod_institucion",
 *       type="string",
 *       required={"true"},
 *       description="The sede name"
 *   ), 
 * 
 *  @OA\Property(
 *       property="nombre",
 *       type="string",
 *       required={"true"},
 *       description="The Sedes nombre"
 *   ),
 *   @OA\Property(
 *       property="telefono",
 *       type="string",
 *       required={"true"},
 *       description="The Sedes telefono"
 *   ),
 *   @OA\Property(
 *       property="direccion",
 *       type="string",
 *       required={"true"},
 *       description="The Sedes direccion"
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
class sedes extends Base
{
      protected $table = 'sedes';
      protected $primaryKey = 'id';
 /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
      'cod_institucion',
      'nombre',
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
      'cod_sede',
      'cod_institucion',
      'nombre',
      'telefono',
      'direccion'
  ];
  
  public function usuarios()
  {
    return $this->belongsToMany(Usuario::class, 'rol_sede_usuarios', 'id_sede', 'id_usuario')
      ->with('roles');
  } 
}