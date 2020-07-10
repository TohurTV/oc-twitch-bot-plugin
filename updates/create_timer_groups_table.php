<?php namespace Tohur\Bot\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateTimerGroupsTable extends Migration
{
    public function up()
    {
        Schema::create('tohur_bot_timer_groups', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name')->default('');
            $table->string('timetorun')->default('');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tohur_bot_timer_groups');
    }
}
