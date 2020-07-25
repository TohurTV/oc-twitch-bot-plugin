<?php namespace Tohur\Bot\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateUsersTable extends Migration
{
    public function up()
    {
        Schema::create('tohur_bot_users', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('twitch_id', 200)->nullable();
            $table->string('twitch', 200)->nullable();
            $table->string('discord_id', 200)->nullable();
            $table->string('discord', 200)->nullable();
            $table->string('points', 200)->nullable();
            $table->string('watchtime', 200)->nullable();
            $table->string('totalmessages', 200)->nullable();
            $table->string('lastseen', 200)->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tohur_bot_users');
    }
}
