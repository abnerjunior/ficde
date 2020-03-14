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
                'hora_e' => '9:00',
                'hora_s' => '10:00',
                'user_r' => 1
            ],
        	[
                'turno' => 'Tarde',
                'dia' => 'Martes',
                'hora_e' => '14:00',
                'hora_s' => '18:00 pm',
                'user_r' => 1
            ]
        ]);
    }
}
