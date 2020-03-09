<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class EstudiantesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('estudiantes')->insert([
            'nombre' => Str::random(10),
            'apellido' => Str::random(10),
            'dni' => Str::random(10),
            'email' => Str::random(10).'@gmail.com',
            'telefono' => Str::random(10),
            'direccion' => Str::random(20),
            'id_curso' => 1,
            'user_r' => Str::random(10)
        ]);
    }
}
