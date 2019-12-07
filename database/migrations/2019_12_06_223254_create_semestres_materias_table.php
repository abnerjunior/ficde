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
        Schema::create('semestres_materias', function (Blueprint $table) {
            $table->string('id');
            $table->string('cod_materia');
            $table->string('cod_semestre');
            $table->string('cod_usuario');
            $table->string('cod_aula');
            
            $table->foreign('cod_materia')->references('cod_materia')->on('materias');
            $table->foreign('cod_semestre')->references('cod_semestre')->on('semestres');
            $table->foreign('cod_usuario')->references('cod_usuario')->on('usuarios');
            $table->foreign('cod_aula')->references('cod_aula')->on('aulas');

            $table->timestamps();
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
