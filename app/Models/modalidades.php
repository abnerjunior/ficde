<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

 /**
 * @OA\Schema(
 *   schema="modalidades",
 *   type="object",
 *   @OA\Property(
 *       property="modalidad",
 *       type="string",
 *       required={"true"},
 *       description="The Turnos name"
 *   ),
 * )
 */

class modalidades extends Base
{
    protected $table = 'modalidades';
    protected $primaryKey = 'cod_modalidad';

      
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'modalidad'
    ];
    /**
     * The attributes that are filterable.
     *
     * @var array
     */
    public static $filterable = [
        'cod_modalidad',
        'modalidad'
    ];
}
