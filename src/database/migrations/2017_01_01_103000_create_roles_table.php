<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRolesTable extends Migration
{
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('menu_id')->unsigned()
                ->index()->nullable();
            $table->foreign('menu_id')->references('id')
                ->on('menus');

            $table->string('name')->unique();
            $table->string('display_name');
            $table->string('description')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('roles');
    }
}
