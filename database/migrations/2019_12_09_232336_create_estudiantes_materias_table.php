<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEstudiantesMateriasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estudiantes_materias', function (Blueprint $table) {
            $table->bigIncrements('cod_em');
            $table->unsignedBigInteger('id_sm');
            $table->unsignedBigInteger('id_turno');
            $table->unsignedBigInteger('id_modalidad');
            $table->unsignedBigInteger('id_estudiante');
            $table->enum('status', ['y','n'])->default('y');
            $table->string('user_r');
            $table->timestamps();
        });

        Schema::table('estudiantes_materias', function($table)
        {

            $table->foreign('id_sm')
            ->references('id_materia')->on('semestre_materias');

            $table->foreign('id_turno')
            ->references('cod_turno')->on('turnos');

            $table->foreign('id_modalidad')
            ->references('cod_modalidad')->on('modalidades');

            $table->foreign('id_estudiante')
            ->references('cod_estudiante')->on('estudiantes'); 
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('estudiantes_materias');
    }
}
