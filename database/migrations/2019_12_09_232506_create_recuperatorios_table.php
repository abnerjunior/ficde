<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRecuperatoriosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recuperatorios', function (Blueprint $table) {
            $table->bigIncrements('cod_recuperatorio');
            $table->string('fecha');
            $table->unsignedBigInteger('id_nota');

            $table->foreign('id_nota')
            ->references('cod_nota')->on('notas');

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
        Schema::dropIfExists('recuperatorios');
    }
}
