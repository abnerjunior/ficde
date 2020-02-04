<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
/**
 * @OA\Schema(
 *   schema="horarios",
 *   type="object",
 *   @OA\Property(
 *       property="dia",
 *       type="string",
 *       required={"true"},
 *       description="The Horario dia"
 *   ),
 *   @OA\Property(
 *       property="hora_inicio",
 *       type="string",
 *       required={"true"},
 *       description="The Horarios hora de inicio"
 *   ),
 *   @OA\Property(
 *       property="hora_final",
 *       type="string",
 *       required={"true"},
 *       description="The Horarios hora_final"
 *   ),
 *   @OA\Property(
 *       property="status",
 *       type="string",
 *       required={"true"},
 *       description="The asistencias telefono"
 *   ),
 *   @OA\Property(
 *       property="user_r",
 *       type="string",
 *       required={"true"},
 *       description="The aulas user_r"
 *   ),
 * )
 */
class horario extends Base
{
    protected $table = 'horarios';
    protected $primaryKey = 'cod_horario';
      
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'dia',
        'hora_inicio',
        'hora_final'
    ];
    /**
     * The attributes that are filterable.
     *
     * @var array
     */
    public static $filterable = [
        'dia',
        'hora_inicio',
        'hora_final'
    ];
}
