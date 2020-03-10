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
        DB::table('usuarios')->insert([
        	['turno' => 'Diurno', 'hora' => '9:00 am', 'user_r' => 1],
        	['turno' => 'Tarde', 'hora' => '2:00 pm', 'user_r' => 1]
        ]);
    }
}
