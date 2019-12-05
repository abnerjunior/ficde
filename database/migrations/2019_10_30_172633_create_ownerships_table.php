<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOwnershipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ownerships', function (Blueprint $table) {
            $table->bigIncrements('ownership_id');
            $table->unsignedBigInteger('condominium_id');
            $table->integer('ownership_number');
            $table->string('ownership_description');
            $table->string('status_ownership');
            $table->string('active_indicator', 1);
            $table->string('create_by', 40)->nullable();
            $table->string('update_by', 40)->nullable();
            $table->timestamps();
            $table->foreign('condominium_id')
                  ->references('condominium_id')
                  ->on('condominiums');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ownerships');
    }
}
