<?php

use Illuminate\Database\Seeder;

class RolsSedeUsuarioTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	DB::table('rol_sede_usuarios')->insert([
    		['id_sede' => 1, 'id_rol' => 1 , 'id_usuario' => 1, 'user_r' => 'Luis Palma']
    	]);
    }
}
