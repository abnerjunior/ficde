<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

/**
 * @OA\Schema(
 *   schema="Login",
 *   type="object",
 *   @OA\Property(
 *       property="email",
 *       required={"true"},
 *       type="string",
 *       description="The Users email"
 *   ),
 *   @OA\Property(
 *       property="password",
 *       type="string",
 *       required={"true"},
 *       description="The email password"
 *   ),
 * )
 */

/**
 * @OA\Schema(
 *   schema="User",
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

class User extends Base implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'lastname',
        'documents',
        'email',
        'phone',
        'password',
        'api_token',
        'remember_token',
        'updated_at',
        'created_at'
    ];
    /**
     * The attributes that are filterable.
     *
     * @var array
     */
    public static $filterable = [
        'user_id',
        'name',
        'lastname',
        'documents',
        'email'
    ];
    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'api_token'
    ];

    protected $primaryKey = 'user_id';
}
