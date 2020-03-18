<?php

use Illuminate\Database\Seeder;

class CursoEstudiantesSeederTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
 		DB::table('curso_estudiantes')->insert([
 			[
 				'id_estudiante' => 1,
 				'id_curso' => 1,
 				'user_r' => 'Luis'
 			]
 		]);
    }
}
