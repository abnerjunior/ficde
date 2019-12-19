<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMateriasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('materias', function (Blueprint $table) {
            $table->bigIncrements('cod_materia');
            $table->unsignedBigInteger('cod_curso');
            $table->string('materia');
            $table->string('descripcion');
            $table->enum('status', ['y','n'])->default('y');

            $table->string('user');
            
            $table->foreign('cod_curso')->references('cod_curso')->on('cursos');

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
        Schema::dropIfExists('materias');
    }
}
