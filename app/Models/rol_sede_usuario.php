<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class rol_sede_usuario extends Pivot
{
    protected $table = 'rol_sede_usuarios';

    protected $incrementing = false;

    public function usuario()
    {
    	return $this->belongsTo(Usuario::class);
    }

    public function rol()
    {
    	return $this->belongsTo(Rol::class);
    }

    public function sede()
    {
    	return $this->belongsTo(sedes::class);
    }
}
