<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
        	UsersTableSeeder::class,
            InstitucionTableSeeder::class,
            SedesTableSeeder::class,
            CursosTableSeeder::class,
            EstudiantesTableSeeder::class,
            AulasTableSeeder::class,
            SemestresTableSeeder::class,
            MateriasTableSeeder::class,
            ModalidadTableSeeder::class,
            TurnoTableSeeder::class,
            CursoEstudiantesSeederTable::class,
            semestreMateriaTableSeeder::class
        ]);
    }
}
