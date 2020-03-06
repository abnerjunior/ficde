<?php

use Illuminate\Database\Seeder;

class SedesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('sedes')->insert(
        	[
        		[ 
	        		'nombre' => 'IUTA Puerto la cruz',
	        		'direccion' => 'Puerto la cruz',
	        		'telefono' => '04249502755',
	        		'cod_institucion' => 1,
	        		'user_r' => 1
	        	],
	        	[ 
	        		'nombre' => 'IUTA Barcelona',
	        		'direccion' => 'Puerto la cruz',
	        		'telefono' => 'Barcelona',
	        		'cod_institucion' => 1,
	        		'user_r' => 1
	        	]
	        ]
	    );
    }
}
