<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class InstitucionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('institucion')->insert(
        	[ 
        		'nombre' => 'IUTA',
        		'registro' => Str::random(10),
        		'telefono' => '04249502755',
        		'direccion' => 'Puerto la cruz',
        		'user_r' => 1
        	]
	    );
    }
}
