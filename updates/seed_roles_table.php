<?php

namespace Tohur\Bot\Updates;

use Carbon\Carbon;
use Tohur\Bot\Models\Roles;
use Schema;
use October\Rain\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;

class SeedRolesTable extends Migration {

    public function up() {

        Roles::create([
            'name' => 'Broadcaster',
            'description' => 'Broadcaster Role',
            'code' => 'broadcaster'
        ]);

        Roles::create([
            'name' => 'Moderator',
            'description' => 'Moderator Role',
            'code' => 'moderator'
        ]);

        Roles::create([
            'name' => 'Vip',
            'description' => 'Vip Role',
            'code' => 'vip'
        ]);
        
        Roles::create([
            'name' => 'Subcriber',
            'description' => 'Subcriber Role',
            'code' => 'subcriber'
        ]);

        Roles::create([
            'name' => 'Follower',
            'description' => 'Follower Role',
            'code' => 'follower'
        ]);
        
        Roles::create([
            'name' => 'Viewer',
            'description' => 'Viewer Role',
            'code' => 'viewer'
        ]);
    }

    public function down() {
        
    }

}
