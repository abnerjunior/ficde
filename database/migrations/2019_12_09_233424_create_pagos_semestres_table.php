<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePagosSemestresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pagos_semestres', function (Blueprint $table) {
            $table->bigIncrements('cod_ps');
            $table->string('sub');
            $table->string('iva');
            $table->string('total');
            $table->string('fecha');
            $table->unsignedBigInteger('id_estudiante');
            $table->unsignedBigInteger('id_semestre');

            $table->timestamps();

        });
       
        Schema::table('pagos_semestres', function($table)
        {

            $table->foreign('id_semestre')
            ->references('cod_semestre')->on('semestres');

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
        Schema::dropIfExists('pagos_semestres');
    }
}
