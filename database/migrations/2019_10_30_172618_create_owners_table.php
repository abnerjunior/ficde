<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOwnersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('owners', function (Blueprint $table) {
            $table->bigIncrements('owner_id');
            $table->string('document');
            $table->string('name');
            $table->string('last_name');
            $table->string('phone');
            $table->string('phone_home');
            $table->string('email', 40)->unique();
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
        Schema::dropIfExists('owners');
    }
}
