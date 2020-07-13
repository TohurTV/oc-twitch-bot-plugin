<?php namespace Tohur\Bot\Updates;

use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class CreateOverlaysTable extends Migration
{
    public function up()
    {
        Schema::create('tohur_bot_overlays', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->string('html')->default('');
            $table->string('css')->default('');
            $table->string('js')->default('');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tohur_bot_overlays');
    }
}
