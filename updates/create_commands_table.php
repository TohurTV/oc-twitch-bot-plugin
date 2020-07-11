<?php namespace Tohur\Bot\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateCommandsTable extends Migration
{
    public function up()
    {
        Schema::create('tohur_bot_commands', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name')->default('');
            $table->string('command')->default('');
            $table->string('response')->default('');
            $table->boolean('args')->default(false);
            $table->boolean('core')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tohur_bot_commands');
    }
}
