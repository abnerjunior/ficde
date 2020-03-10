<?php

use Illuminate\Database\Seeder;

class ModalidadTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('modalidades')->insert([
        	['modalidad' => 'Presencial', 'user_r' => 1],
        	['modalidad' => 'Onlne', 'user_r' => 1],
        ]);
    }
}
