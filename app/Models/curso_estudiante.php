<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class curso_estudiante extends Pivot
{
    protected $table = 'curso_estudiantes';

    protected $primaryKey = 'curso_estudiantes_id_curso_foreign';

    protected $incrementing = false;
}
