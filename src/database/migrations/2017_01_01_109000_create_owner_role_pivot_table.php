<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOwnerRolePivotTable extends Migration
{
    public function up()
    {
        Schema::create('owner_role', function (Blueprint $table) {
            $table->integer('role_id')->unsigned()->index();
            $table->foreign('role_id')->references('id')->on('roles')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->integer('owner_id')->unsigned()->index();
            $table->foreign('owner_id')->references('id')->on('owners')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
            $table->primary(['role_id', 'owner_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('owner_role');
    }
}
