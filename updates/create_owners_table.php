<?php namespace Tohur\Bot\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateOwnersTable extends Migration
{
    public function up()
    {
        Schema::create('tohur_bot_owners', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('twitch_id')->default('');
            $table->string('twitch')->default('');
            $table->string('discord_id')->default('');
            $table->string('discord')->default('');
            $table->string('game')->default('');
            $table->string('twitch_token')->default('');
            $table->string('twitch_refreshToken')->default('');
            $table->string('twitch_expiresIn')->default('');
            $table->boolean('livepostsent')->default(false);
            $table->boolean('tweetsent')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tohur_bot_owners');
    }
}