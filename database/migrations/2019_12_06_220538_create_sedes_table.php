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
            $table->bigIncrements('cod_sede');
            $table->string('nombre');
            $table->string('direccion');
            $table->string('telefono');
            $table->unsignedBigInteger('cod_institucion');
            $table->enum('status', ['y','n'])->default('y');

            $table->string('user_r');

            $table->foreign('cod_institucion')
            ->references('cod_institucion')->on('institucion');

            $table->softDeletes();
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
