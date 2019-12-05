<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGroupPeopleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('group_peoples', function (Blueprint $table) {
            $table->bigIncrements('group_people_id');
            $table->unsignedBigInteger('owner_id');
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
        Schema::dropIfExists('group_peoples');
    }
}
