<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;


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
 *       property="fecha",
 *       type="string",
 *       required={"true"},
 *       description="The semestres fecha"
 *   ),
 * )
 */

class semestres extends Model
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
        'fecha'
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
