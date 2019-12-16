<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePagosRecuperatoriosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pagos_recuperatorios', function (Blueprint $table) {
            $table->bigIncrements('cod_pr');
            $table->string('sub');
            $table->string('iva');
            $table->string('total');
            $table->string('fecha');
            $table->unsignedBigInteger('id_estudiante');
            $table->unsignedBigInteger('id_nota');
            $table->boolean('status');
            $table->string('user');

            $table->timestamps();

        });

        Schema::table('pagos_recuperatorios', function($table)
        {

            $table->foreign('id_nota')
            ->references('cod_nota')->on('notas');

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
        Schema::dropIfExists('pagos_recuperatorios');
    }
}
