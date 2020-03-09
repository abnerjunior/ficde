<?php

use Illuminate\Database\Seeder;

class AulasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('aulas')->insert(
        	[
        		[ 
	        		'cod_sede' => 1,
	        		'nombre' => 'Aula202',
	        		'capacidad' => '200',
	        		'user_r' => 1
	        	],
        		[ 
	        		'cod_sede' => 2,
	        		'nombre' => 'Aula202',
	        		'capacidad' => '200',
	        		'user_r' => 1
	        	]
	        ]
	    );
    }
}
