<?php

namespace Tohur\Bot\Components;

use Cms\Classes\ComponentBase;
use Tohur\Bot\Models\CoreCommands;
use Tohur\Bot\Models\CustomCommands;
use Tohur\Bot\Models\Roles;

class Commands extends ComponentBase {

    public function componentDetails() {
        return [
            'name' => 'Commands Component',
            'description' => 'No description provided yet...'
        ];
    }

    public function defineProperties() {
        return [];
    }

    public function corecommands() {
        return CoreCommands::orderBy('command')->get();
    }

    public function customcommands() {
        return CustomCommands::orderBy('command')->get();
    }

    public function permission($id) {
        $findRole = Roles::where('id', $id)->first();
        $roleName = $findRole->name;
        return $roleName;
    }

}
