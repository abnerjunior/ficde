<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTurnoSemestreMateriasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('turno_semestre_materias', function (Blueprint $table) {
            $table->unsignedBigInteger('id_sm');
            $table->unsignedBigInteger('id_turno');
            $table->primary(['id_sm', 'id_turno']);
            $table->string('user_r');
            $table->timestamps();

            $table->foreign('id_sm')
            ->references('cod_sm')->on('semestres_materias');
            $table->foreign('id_turno')
            ->references('cod_turno')->on('turnos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('turno_semestre_materias');
    }
}
