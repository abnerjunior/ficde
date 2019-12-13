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
 *       property="capasidad",
 *       type="string",
 *       required={"true"},
 *       description="The aulas capasidad"
 *   ),
 *   @OA\Property(
 *       property="cod_sede",
 *       type="string",
 *       required={"true"},
 *       description="The aulas cod_sede"
 *   ),
 * )
 */

class aulas extends Model
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
          'capasidad',
          'cod_sede'
      ];
      /**
       * The attributes that are filterable.
       *
       * @var array
       */
      public static $filterable = [
          'cod_aula',
          'nombre',
          'capasidad',
          'cod_sede'         
      ];
}
