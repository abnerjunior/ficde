<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAsistenciasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asistencias', function (Blueprint $table) {
            $table->bigIncrements('cod_asistencia');
            $table->unsignedBigInteger('id_sm');
            $table->unsignedBigInteger('id_estudiante');
            $table->boolean('estatus');
            $table->enum('status', ['y','n'])->default('y');

            $table->string('user_r');

            $table->foreign('id_sm')
            ->references('cod_sm')->on('semestres_materias');

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
        Schema::dropIfExists('asistencias');
    }
}
