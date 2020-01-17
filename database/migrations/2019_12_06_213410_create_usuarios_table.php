<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsuariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->bigIncrements('cod_usuario');
            $table->string('user');
            $table->string('pass');
            $table->string('nombre');
            $table->string('apellido');
            $table->string('dni');
            $table->string('direccion');
            $table->string('telefono');
            $table->string('email');
            $table->string('rol');
            $table->enum('status', ['y','n'])->default('y');
            $table->string('user_r');
            $table->string('api_token',200)->nullable();


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
        Schema::dropIfExists('usuarios');
    }
}
