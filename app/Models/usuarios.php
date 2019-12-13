<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

/**
 * @OA\Schema(
 *  schema="Login",
 *  type="object",
 *   @OA\Property(
 *       property="dni",
 *       type="string",
 *       required={"true"},
 *       description="The user dni"
 *   ),
 *  type="object",
 *  @OA\Property(
 *       property="pass",
 *       type="string",
 *       required={"true"},
 *       description="The user password"
 *   ),
 * )
 */

/**
 * @OA\Schema(
 *   schema="usuarios",
 *   type="object",
 *   @OA\Property(
 *       property="name",
 *       type="string",
 *       required={"true"},
 *       description="The user name"
 *   ),
 *   @OA\Property(
 *       property="lastname",
 *       type="string",
 *       required={"true"},
 *       description="The user lastname"
 *   ),
 *   @OA\Property(
 *       property="documents",
 *       type="string",
 *       required={"true"},
 *       description="The user documents"
 *   ),
 *   @OA\Property(
 *       property="email",
 *       required={"true"},
 *       type="string",
 *       description="The Users email"
 *   ),
 *   @OA\Property(
 *       property="phone",
 *       type="string",
 *       required={"true"},
 *       description="The Users phone"
 *   ),
 *   @OA\Property(
 *       property="password",
 *       type="string",
 *       required={"true"},
 *       description="The Users password"
 *   ),
 * )
 */

class usuarios extends Model implements AuthenticatableContract, AuthorizableContract
{
      use Authenticatable, Authorizable;
      /**
       * The attributes that are mass assignable.
       *
       * @var array
       */

      protected $fillable = [
            'user',
            'pass',
            'nombre',
            'apellido',
            'dni',
            'email',
            'telefono',
            'direccion',
            'rol'
        ];
        /**
         * The attributes that are filterable.
         *
         * @var array
         */
        public static $filterable = [
            'cod_usuario',
            'user',
            'dni',
            'nombre',
            'apellido',
            'email'
        ];
        /**
         * The attributes excluded from the model's JSON form.
         *
         * @var array
         */
        protected $hidden = [
            'password'
        ];
    
        protected $primaryKey = 'cod_usuario';
}
