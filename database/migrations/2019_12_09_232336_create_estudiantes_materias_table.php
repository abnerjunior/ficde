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
            $table->unsignedBigInteger('id_sm');
            $table->unsignedBigInteger('id_estudiante');
            $table->primary(['id_sm', 'id_estudiante']);
            $table->enum('status', ['y','n'])->default('y');
            $table->string('user_r');
            $table->timestamps();
        });

        Schema::table('estudiantes_materias', function($table)
        {

            $table->foreign('id_sm')
            ->references('cod_sm')->on('semestres_materias');

            $table->foreign('id_estudiante')
            ->references('id')->on('estudiantes');

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
