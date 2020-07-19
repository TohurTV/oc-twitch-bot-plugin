<?php

namespace Tohur\Bot\Classes\Twitch;

use Tohur\Bot\Classes\Helpers\FunctionsClass;
use Tohur\Bot\Models\Commands as CommandsDB;
use Tohur\Bot\Classes\Helpers\HelperClass;
use Tohur\Twitchirc\AbstractPlugin as BasePlugin;
use Tohur\Twitchirc\IRC\Response;

class CoreCommands extends BasePlugin {

    /**
     * Does the 'heavy lifting' of initializing the plugin's behavior
     */
    public function init() {
        $this->bot->onChannel('/^!echo (.*)$/', function($event) {
            $request = $event->getRequest();
            $matches = $event->getMatches();
            $event->addResponse(Response::msg($request->getSource(), trim($matches[0])));
        });
        $this->bot->onChannel('/^!echo (.*)$/', function($event) {
            $request = $event->getRequest();
            $matches = $event->getMatches();
            $event->addResponse(Response::msg($request->getSource(), trim($matches[0])));
        });
    }

    /**
     * Returns the Plugin's name
     */
    public function getName() {
        return 'CoreCommands';
    }

}
