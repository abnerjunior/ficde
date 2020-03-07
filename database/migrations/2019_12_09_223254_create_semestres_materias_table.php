<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSemestresMateriasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('semestres_materias', function (Blueprint $table) 
        {
            $table->primary(['id_materia', 'id_semestres', 'id_usuario', 'id_aula'], 'id_primary_key');
            $table->unsignedBigInteger('id_materia');
            $table->unsignedBigInteger('id_semestres');
            $table->unsignedBigInteger('id_usuario');
            $table->unsignedBigInteger('id_aula');
            $table->enum('status', ['y','n'])->default('y');

            $table->string('user_r');

            $table->timestamps();
        });

        Schema::table('semestres_materias', function($table)
        {

            $table->foreign('id_materia')
            ->references('cod_materia')->on('materias');

            $table->foreign('id_usuario')
            ->references('cod_usuario')->on('usuarios');

            $table->foreign('id_semestres')
            ->references('cod_semestre')->on('semestres');

            $table->foreign('id_aula')
            ->references('cod_aula')->on('aulas'); 
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('semestres_materias');
    }
}
