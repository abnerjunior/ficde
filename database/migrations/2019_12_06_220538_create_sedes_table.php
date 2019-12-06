<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSedesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sedes', function (Blueprint $table) {
            $table->string('cod_sede');
            $table->bigIncrements('nombre');
            $table->bigIncrements('direccion');
            $table->bigIncrements('telefono');
            $table->bigIncrements('cod_institucion');

            $table->foreign('cod_institucion')->references('cod_institucion')->on('institucion');

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
        Schema::dropIfExists('sedes');
    }
}
