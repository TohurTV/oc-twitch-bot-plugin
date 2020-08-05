<?php namespace Tohur\Bot\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateCustomCommandsTable extends Migration
{
    public function up()
    {
        Schema::create('tohur_bot_custom_commands', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name')->default('');
            $table->string('command')->default('');
            $table->string('response', 500)->default('');
            $table->string('description', 500)->default('');
            $table->boolean('args')->default(false);
            $table->integer('permission_id')->unsigned()->nullable();
            $table->foreign('permission_id')->references('id')->on('tohur_bot_botpermissions_permissions');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tohur_bot_custom_commands');
    }
}
