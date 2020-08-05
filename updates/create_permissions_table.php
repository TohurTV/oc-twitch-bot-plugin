<?php namespace Tohur\Bot\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreatePermissionsTable extends Migration
{
    public function up()
    {
        Schema::create('tohur_bot_botpermissions_permissions', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('code')->unique();
            $table->string('name')->nullable();
            $table->string('description')->nullable();
            $table->timestamps();
        });

        Schema::create('tohur_bot_botpermissions_user_permission', function($table)
        {
            $table->engine = 'InnoDB';
            $table->integer('user_id')->unsigned();
            $table->integer('permission_id')->unsigned();
            $table->tinyInteger('permission_state');
            $table->primary(['user_id', 'permission_id'], 'user_permission_id');
            $table->timestamps();
        });

        Schema::create('tohur_bot_botpermissions_role_permission', function($table)
        {
            $table->engine = 'InnoDB';
            $table->integer('role_id')->unsigned();
            $table->integer('permission_id')->unsigned();
            $table->tinyInteger('permission_state');
            $table->primary(['role_id', 'permission_id'], 'role_permission_id');
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('tohur_bot_botpermissions_role_permission');
        Schema::dropIfExists('tohur_bot_botpermissions_user_permission');
        Schema::dropIfExists('tohur_bot_botpermissions_permissions');
    }
}
