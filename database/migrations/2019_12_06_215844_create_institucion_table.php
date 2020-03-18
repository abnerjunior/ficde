<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInstitucionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('institucion', function (Blueprint $table) {
            $table->bigIncrements('cod_institucion');
            $table->string('nombre');
            $table->string('registro');
            $table->string('telefono');
            $table->string('direccion');
            $table->enum('status', ['y','n'])->default('y');

            $table->unsignedBigInteger('user_r');
            $table->foreign('user_r')->references('cod_usuario')->on('usuarios');

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
        Schema::dropIfExists('institucion');
    }
}
