<?php namespace Tohur\Bot\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateWatchedTable extends Migration
{
    public function up()
    {
        Schema::create('tohur_bot_watched', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('botuser_id')->unsigned();
            $table->foreign('botuser_id')->references('id')->on('tohur_bot_users');
            $table->bigInteger('time');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tohur_bot_watched');
    }
}
