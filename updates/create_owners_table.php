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
            $table->string('twitch_id')->nullable();
            $table->string('twitch')->nullable();
            $table->string('discord_id')->nullable();
            $table->string('discord')->nullable();
            $table->string('twitch_token')->nullable();
            $table->string('twitch_refreshToken')->nullable();
            $table->string('twitch_expiresIn')->nullable();
            $table->string('token_created_at')->nullable();
            $table->string('token_updated_at')->nullable();
            $table->string('game')->nullable();
            $table->string('latestfollower')->nullable();
            $table->string('latestsub')->nullable();
            $table->string('latesthost')->nullable();
            $table->string('latestraid')->nullable();
            $table->string('latestbitsuser')->nullable();
            $table->string('latestbitsamount')->nullable();
            $table->boolean('livepostsent')->default(false);
            $table->boolean('tweetsent')->default(false);
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('tohur_bot_owners');
    }

}
