<?php

use Illuminate\Database\Seeder;

class SemestresTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		DB::table('semestres')->insert([
			[
				'nombre' => 'Primer Semestre',
				'fecha_inicio' => '202-01-02',
				'fecha_final' => '202-01-05',
				'user_r' => 1
			],
			[
				'nombre' => 'Segundo Semestre',
				'fecha_inicio' => '202-01-02',
				'fecha_final' => '202-01-05',
				'user_r' => 1
			]
		]);
    }
}
