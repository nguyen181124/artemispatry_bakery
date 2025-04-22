<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCakeTable extends Migration
{
    public function up()
    {
        Schema::create('cake', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('img');
            $table->integer('price');
            $table->text('info');
            $table->integer('category')->unsigned();
        });
    }

    public function down()
    {
        Schema::dropIfExists('cake');
    }
};
