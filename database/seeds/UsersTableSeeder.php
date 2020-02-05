<?php

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('usuarios')->insert([
            'nombre' => Str::random(10),
            'apellido' => Str::random(10),
            'dni' => Str::random(10),
            'email' => Str::random(10).'@gmail.com',
            'telefono' => Str::random(10),
            'pass' => Hash::make('secret'),
            'rol' => 'Admin',
            'direccion' => Str::random(20),
            'user' => 'admin',
            'user_r' => Str::random(10),
            'api_token' => Str::random(50)
        ]);
    }
}
