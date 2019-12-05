<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class OwnershipOwners extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ownerships_owners', function (Blueprint $table) {
            $table->bigIncrements('ownerships_owners_id');
            $table->unsignedBigInteger('ownership_id');
            $table->unsignedBigInteger('owner_id');
            $table->foreign('ownership_id')
                  ->references('ownership_id')
                  ->on('ownerships');
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
