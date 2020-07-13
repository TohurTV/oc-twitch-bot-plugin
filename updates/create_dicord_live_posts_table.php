<?php namespace Tohur\Bot\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateDicordLivePostsTable extends Migration
{
    public function up()
    {
        Schema::create('tohur_bot_dicord_live_posts', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('channel')->default('');
            $table->string('discord')->default('');
            $table->boolean('sent')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tohur_bot_dicord_live_posts');
    }
}
