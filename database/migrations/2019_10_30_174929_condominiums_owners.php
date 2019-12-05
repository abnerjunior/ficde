<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CondominiumsOwners extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('condominiums_owners', function (Blueprint $table) {
            $table->bigIncrements('condominiums_owners_id');
            $table->unsignedBigInteger('condominium_id');
            $table->unsignedBigInteger('owner_id');
            $table->foreign('condominium_id')
                  ->references('condominium_id')
                  ->on('condominiums');
            $table->foreign('owner_id')
                  ->references('owner_id')
                  ->on('owners');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
