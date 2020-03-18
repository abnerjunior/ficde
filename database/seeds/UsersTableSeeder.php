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
        DB::table('usuarios')->insert(
            [
                [
                    'nombre' => Str::random(10),
                    'apellido' => Str::random(10),
                    'dni' => 28298930,
                    'email' => Str::random(10).'@gmail.com',
                    'telefono' => Str::random(10),
                    'pass' => Hash::make('secret'),
                    'rol' => 'Admin',
                    'direccion' => Str::random(20),
                    'user' => 'admin',
                    'user_r' => Str::random(10),
                    'api_token' => Str::random(50)
                ],
                [
                    'nombre' => 'Luis Alejandro',
                    'apellido' => 'Palma',
                    'dni' => '26720270',
                    'email' => Str::random(10).'@gmail.com',
                    'telefono' => Str::random(10),
                    'pass' => Hash::make('secret'),
                    'rol' => 'teacher',
                    'direccion' => Str::random(20),
                    'user' => 'palma001',
                    'user_r' => Str::random(10),
                    'api_token' => Str::random(50)
                ]
            ]
        );
    }
}
