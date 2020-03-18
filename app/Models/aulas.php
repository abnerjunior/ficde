<?php

namespace App\Models;
use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

/**
 * @OA\Schema(
 *   schema="aulas",
 *   type="object",
 *   @OA\Property(
 *       property="nombre",
 *       type="string",
 *       required={"true"},
 *       description="The Institucion nombre"
 *   ),
 *   @OA\Property(
 *       property="capacidad",
 *       type="string",
 *       required={"true"},
 *       description="The aulas capacidad"
 *   ),
 *   @OA\Property(
 *       property="cod_sede",
 *       type="string",
 *       required={"true"},
 *       description="The aulas cod_sede"
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

class aulas extends Base
{
      protected $table = 'aulas';
      protected $primaryKey = 'cod_aula';
        
      /**
       * The attributes that are mass assignable.
       *
       * @var array
       */
      protected $fillable = [
          'nombre',
          'capacidad',
          'cod_sede',
          'status',
          'user_r'
      ];
      /**
       * The attributes that are filterable.
       *
       * @var array
       */
      public static $filterable = [
          'cod_aula',
          'nombre',
          'capacidad',
          'cod_sede'         
      ];
}
