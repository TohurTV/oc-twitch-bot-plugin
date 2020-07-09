<?php namespace Tohur\Bot\Updates;

use Carbon\Carbon;
use Tohur\Bot\Models\Commands;
use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class SeedCommandsTable extends Migration
{
    public function up()
    {
        Commands::create(['name' => 'Followage', 'command' => 'followage', 'response' => 'followage', 'core' => true]);
    }

    public function down()
    {

    }
}
