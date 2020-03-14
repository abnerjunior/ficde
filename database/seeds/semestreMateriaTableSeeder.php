<?php

use Illuminate\Database\Seeder;

class semestreMateriaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('semestres_materias')->insert([
        	[
				'id_materia' => 1,
				'id_semestres' => 1,
				'id_usuario' => 2,
				'id_aula' => 1,
				'id_turno' => 1
        	],
        	[
				'id_materia' => 1,
				'id_semestres' => 2,
				'id_usuario' => 2,
				'id_aula' => 2,
				'id_turno' => 2
        	]
        ]);
    }
}
