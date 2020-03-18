<?php

use Illuminate\Database\Seeder;

class TurnoSemestreMateriasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('turno_semestre_materias')->insert([
            [
                'id_sm' => 1,
                'id_turno' => 1,
                'user_r' => 'Luis Palma'
            ],
            [
                'id_sm' => 1,
                'id_turno' => 2,
                'user_r' => 'Luis Palma'
            ],
            [
                'id_sm' => 2,
                'id_turno' => 2,
                'user_r' => 'Luis Palma'
            ],
            [
                'id_sm' => 2,
                'id_turno' => 1,
                'user_r' => 'Luis Palma'
            ]
        ]);
    }
}
