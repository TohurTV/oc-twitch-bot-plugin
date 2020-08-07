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
            $table->integer('users_id')->unsigned();
            $table->integer('roles_id')->unsigned();
            $table->primary(['users_id', 'roles_id'], 'users_roles');
        });
    }

    public function down()
    {
        Schema::dropIfExists('tohur_bot_user_roles');
    }
}
