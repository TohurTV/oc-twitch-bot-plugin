<?php

namespace Tohur\Bot\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateOwnersTable extends Migration {

    public function up() {
        Schema::create('tohur_bot_owners', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('twitch_id', 200)->nullable();
            $table->string('twitch', 200)->nullable();
            $table->string('discord_id', 200)->nullable();
            $table->string('discord', 200)->nullable();
            $table->string('twitch_token', 200)->nullable();
            $table->string('twitch_refreshToken', 200)->nullable();
            $table->string('twitch_expiresIn', 200)->nullable();
            $table->string('token_created_at', 200)->nullable();
            $table->string('token_updated_at', 200)->nullable();
             $table->string('title', 200)->nullable();
            $table->string('game', 200)->nullable();
            $table->string('latestfollower', 200)->nullable();
            $table->string('latestsub', 200)->nullable();
            $table->string('latesthost', 200)->nullable();
            $table->string('latestraid', 200)->nullable();
            $table->string('latestbitsuser', 200)->nullable();
            $table->string('latestbitsamount', 200)->nullable();
            $table->boolean('livepostsent')->default(false);
            $table->boolean('tweetsent')->default(false);
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('tohur_bot_owners');
    }

}
