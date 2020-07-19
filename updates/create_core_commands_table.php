<?php

namespace Tohur\Bot\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateCoreCommandsTable extends Migration {

    public function up() {
        Schema::create('tohur_bot_core_commands', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name')->default('');
            $table->string('command')->default('');
            $table->string('response', 500)->default('');
            $table->string('description', 500)->default('');
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('tohur_bot_core_commands');
    }

}
