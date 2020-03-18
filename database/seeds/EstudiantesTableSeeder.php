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
            'nombre' => 'Oriana Andreina',
            'apellido' => 'Lopez Meza',
            'dni' => 28298930,
            'email' => 'orianalopez@gmail.com',
            'telefono' => 4249502755,
            'direccion' => Str::random(50),
            'user_r' => Str::random(10)
        ]);
    }
}
