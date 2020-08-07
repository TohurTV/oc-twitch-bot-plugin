<?php

namespace Tohur\Bot\Updates;

use Carbon\Carbon;
use Tohur\Bot\Models\CoreCommands;
use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class SeedCoreCommandsTable extends Migration {

    public function up() {
        CoreCommands::create([
            'name' => 'Followage',
            'command' => 'followage',
            'response' => '{$targetuser} has been following for {$followage}!',
            'description' => 'Shows a users Follow Age on The Channel.'
        ]);

        CoreCommands::create([
            'name' => 'Age',
            'command' => 'age',
            'response' => '{$targetuser}s account is {$age} old!',
            'description' => 'Shows a users account age.'
        ]);

        CoreCommands::create([
            'name' => 'Uptime',
            'command' => 'uptime',
            'response' => '{$user} has been live for {$uptime}!',
            'description' => 'Shows channels uptime.'
        ]);

        CoreCommands::create([
            'name' => 'Subs',
            'command' => 'subs',
            'response' => '{$user} has {$subs} subs!',
            'description' => 'Shows channels sub count.'
        ]);

        CoreCommands::create([
            'name' => 'Followers',
            'command' => 'followers',
            'response' => '{$user} has {$followers} followers!',
            'description' => 'Shows channels follow count.'
        ]);

        CoreCommands::create([
            'name' => 'Lastseen ',
            'command' => 'lastseen ',
            'response' => '{$targetuser} was last seen on {$lastseen}!',
            'description' => 'Shows last time user chatted on channel.'
        ]);

        CoreCommands::create([
            'name' => 'Watch Time',
            'command' => 'watchtime',
            'response' => '{$targetuser} has watched {$user} for {$watchtime}!',
            'description' => 'Shows show total time a user has watched channel.'
        ]);

        CoreCommands::create([
            'name' => 'Stats',
            'command' => 'stats ',
            'response' => '{$targetuser} has {$points} points, watched for {$watchtime}, and has sent {$totalmessages}.',
            'description' => 'Shows points, watched time of user and message count with optional username.'
        ]);
    }

    public function down() {
        
    }

}
