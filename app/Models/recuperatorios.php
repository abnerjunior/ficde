<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;


/**
 * @OA\Schema(
 *   schema="recuperatorios",
 *   type="object",
 *   @OA\Property(
 *       property="fecha",
 *       type="string",
 *       required={"true"},
 *       description="The recuperatorios fecha"
 *   ),
 *   @OA\Property(
 *       property="id_nota",
 *       type="string",
 *       required={"true"},
 *       description="The recuperatorios id_nota"
 *   ),
 *   @OA\Property(
 *       property="nota_r",
 *       type="string",
 *       required={"true"},
 *       description="The recuperatorios id_nota"
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

class recuperatorios extends Base
{
    protected $table = 'recuperatorios';
    protected $primaryKey = 'cod_recuperatorio';
      
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'fecha',
        'id_nota',
        'status',
        'user_r'
    ];
    /**
     * The attributes that are filterable.
     *
     * @var array
     */
    public static $filterable = [
        'cod_recuperatorio',
        'id_nota'
    ];
}
