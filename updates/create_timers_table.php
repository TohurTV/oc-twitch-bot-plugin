<?php namespace Tohur\Bot\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateTimersTable extends Migration
{
    public function up()
    {
        Schema::create('tohur_bot_timers', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('timersgroups_id')->unsigned();
            $table->foreign('timersgroups_id')->references('id')->on('tohur_bot_timer_groups');
            $table->string('name')->default('');
            $table->string('response', 500)->default('');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tohur_bot_timers');
    }
}
