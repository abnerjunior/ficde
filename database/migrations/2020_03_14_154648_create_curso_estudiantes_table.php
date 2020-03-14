<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCursoEstudiantesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('curso_estudiantes', function (Blueprint $table) {
            $table->bigIncrements('cod_ce');
            $table->unsignedBigInteger('id_estudiante');
            $table->unsignedBigInteger('id_curso');
            $table->foreign('id_estudiante')
            ->references('cod_estudiante')->on('estudiantes');

            $table->foreign('id_curso')
            ->references('cod_curso')->on('cursos');
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
        Schema::dropIfExists('curso_estudiantes');
    }
}
