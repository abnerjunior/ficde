<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;

class curso_estudiante extends Pivot
{
    protected $table = 'curso_estudiantes';

    protected $primaryKey = 'id_primary_curso_estudiantes';

   	public $incrementing = false;
}
