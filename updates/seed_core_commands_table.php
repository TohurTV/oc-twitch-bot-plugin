<?php namespace Tohur\Bot\Updates;

use Carbon\Carbon;
use Tohur\Bot\Models\CoreCommands;
use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class SeedCoreCommandsTable extends Migration
{
    public function up()
    {
        CoreCommands::create(['name' => 'Followage', 'command' => 'followage', 'response' => '{$followage}']);
    }

    public function down()
    {

    }
}
