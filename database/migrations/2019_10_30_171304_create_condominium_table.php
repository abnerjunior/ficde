<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCondominiumTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('condominiums', function (Blueprint $table) {
            $table->bigIncrements('condominium_id');
            $table->string('name');
            $table->string('phone');
            $table->string('email', 40)->unique();
            $table->string('type_condominium');
            $table->string('active_indicator', 1);
            $table->string('create_by', 40)->nullable();
            $table->string('update_by', 40)->nullable();
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
        Schema::dropIfExists('condominiums');
    }
}
