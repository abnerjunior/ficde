<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRolSedeUsuariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rol_sede_usuarios', function (Blueprint $table) {
            $table->unsignedBigInteger('id_rol');
            $table->unsignedBigInteger('id_sede');
            $table->unsignedBigInteger('id_usuario');
            $table->primary(['id_rol', 'id_sede', 'id_usuario']);
            $table->string('user_r');
            $table->timestamps();

            $table->foreign('id_rol')
            ->references('id')->on('rols');
            $table->foreign('id_sede')
            ->references('id')->on('sedes');
            $table->foreign('id_usuario')
            ->references('cod_usuario')->on('usuarios');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rol_sede_usuarios');
    }
}
