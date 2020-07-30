<?php

namespace Tohur\Bot\Components;

use Cms\Classes\ComponentBase;
use Tohur\Bot\Models\CoreCommands;
use Tohur\Bot\Models\CustomCommands;

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
        return CoreCommands::all();
    }

    public function customcommands() {
        return CustomCommands::all();
    }

}
