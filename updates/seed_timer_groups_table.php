<?php namespace Tohur\Bot\Updates;

use Carbon\Carbon;
use Tohur\Bot\Models\TimerGroups;
use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class SeedTimerGroupsTable extends Migration
{
    public function up()
    {
        TimerGroups::create(['name' => 'Default', 'timetorun' => '15']);
    }

    public function down()
    {

    }
}
