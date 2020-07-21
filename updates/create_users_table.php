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
            $table->string('twitch_id')->default('');
            $table->string('twitch')->default('');
            $table->string('discord_id')->default('');
            $table->string('discord')->default('');
            $table->string('lastseen', 200)->default('');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tohur_bot_points');
        Schema::dropIfExists('tohur_bot_watched');
        Schema::dropIfExists('tohur_bot_users');
    }
}
