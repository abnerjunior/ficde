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
            $table->bigIncrements('id_sm');
           
            $table->timestamps();
        });

        Schema::table('semestres_materias', function($table)
        {
            
            $table->unsignedBigInteger('cod_materia');
            $table->unsignedBigInteger('cod_semestres');
            $table->unsignedBigInteger('cod_usuario');
            $table->unsignedBigInteger('cod_aula');
            
            $table->foreign('cod_materia')
            ->references('cod_materia')->on('materias');

            $table->foreign('cod_usuario')
            ->references('cod_usuario')->on('usuarios');

            $table->foreign('cod_semestres')
            ->references('cod_semestres')->on('semestres');

            $table->foreign('cod_aula')
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
