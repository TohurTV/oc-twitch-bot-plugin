<?php

namespace Tohur\Bot\Classes\Twitch;

use Tohur\Bot\Classes\Helpers\FunctionsClass;
use Tohur\Bot\Models\CustomCommands as CommandDB;
use Tohur\Bot\Classes\Helpers\HelperClass;
use Tohur\Bot\Models\Users;
use Tohur\Bot\Models\Points;
use Tohur\Twitchirc\AbstractPlugin as BasePlugin;
use Tohur\Twitchirc\IRC\Response;

class UserTracking extends BasePlugin {

    /**
     * Does the 'heavy lifting' of initializing the plugin's behavior
     */
    public function init() {
        $this->bot->onChannel('/^(.*)$/', function ($event) {
            $helper = new HelperClass();
            $request = $event->getRequest();
            $matches = $event->getMatches();
        });
    }

    /**
     * Returns the Plugin's name
     */
    public function getName() {
        return 'UserTracking';
    }

}
