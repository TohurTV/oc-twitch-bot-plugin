<?php namespace Tohur\Bot\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateUserRolesTable extends Migration
{
    public function up()
    {
        Schema::create('tohur_bot_user_roles', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->integer('user_id')->unsigned();
            $table->integer('user_role_id')->unsigned();
            $table->primary(['user_id', 'user_role_id'], 'user_role');
        });
    }

    public function down()
    {
        Schema::dropIfExists('tohur_bot_user_roles');
    }
}
