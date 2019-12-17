<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJustificadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('justificados', function (Blueprint $table) {
            $table->bigIncrements('cod_justificado');
            $table->string('tipo');
            $table->string('fecha');
            $table->unsignedBigInteger('id_asistencia');
            $table->string('status');
            $table->string('user');

            $table->foreign('id_asistencia')
            ->references('cod_asistencia')->on('asistencias');

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
        Schema::dropIfExists('justificados');
    }
}
