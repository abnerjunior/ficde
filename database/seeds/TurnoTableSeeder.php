<?php

use Illuminate\Database\Seeder;

class TurnoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('turnos')->insert([
        	[
                'turno' => 'Diurno',
                'dia' => 'Lunes',
                'hora_e' => '9:00 am',
                'hora_s' => '10:00 am',
                'user_r' => 1
            ],
        	[
                'turno' => 'Tarde',
                'dia' => 'Lunes',
                'hora_e' => '2:00 pm',
                'hora_s' => '3:00 pm',
                'user_r' => 1
            ]
        ]);
    }
}
