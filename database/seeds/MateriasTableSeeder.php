<?php

use Illuminate\Database\Seeder;

class MateriasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('materias')->insert([
        	[
        		'cod_curso' => 1,
        		'materia' => 'Matematica',
        		'descripcion' => 'Matematica 1',
        		'user_r' => 1
        	],
        	[
        		'cod_curso' => 1,
        		'materia' => 'Ingles Basico',
        		'descripcion' => 'Ingles Basico',
        		'user_r' => 1
        	],
        	[
        		'cod_curso' => 1,
        		'materia' => 'Contabilidad',
        		'descripcion' => 'Contabilidad 1',
        		'user_r' => 1
        	]
        ]);
    }
}
