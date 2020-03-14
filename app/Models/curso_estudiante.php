<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;

class curso_estudiante extends Pivot
{
    protected $table = 'curso_estudiantes';

    public $primaryKey = 'curso_estudiantes_id_curso_foreign';

   	public $incrementing = true;
}
