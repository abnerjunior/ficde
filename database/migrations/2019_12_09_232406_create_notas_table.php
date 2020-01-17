<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notas', function (Blueprint $table) {
            $table->bigIncrements('cod_nota');
            $table->string('nota');
            $table->unsignedBigInteger('id_em');
            $table->unsignedBigInteger('id_estudiante');
            $table->enum('status', ['y','n'])->default('y');

            $table->string('user_r');

            $table->timestamps();
        });

        Schema::table('notas', function($table)
        {

            $table->foreign('id_em')
            ->references('cod_em')->on('estudiantes_materias');

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
        Schema::dropIfExists('notas');
    }
}
