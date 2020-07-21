<?php

namespace Tohur\Bot\Classes\Twitch;

use Tohur\Bot\Classes\Helpers\FunctionsClass;
use Tohur\Bot\Models\CoreCommands as CommandsDB;
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
        // Follow Age Command
        $this->bot->onChannel('/^!followage(.*)$/', function($event) {
            $helper = new HelperClass();
            $function = new FunctionsClass();
            $request = $event->getRequest();
            $matches = $event->getMatches();

            $command = CommandsDB::where('command', 'followage')->first();
            if (empty($matches[0])) {
                $targetUser = $request->getSendingUser();
            } else {
                $targetUser = trim($matches[0]);
                
            }
            $replace = array(
                '{$followage}' => $function->followage($targetUser),
                '{$targetuser}' => $targetUser,
            );
            $formated = strtr($command->response, $replace);
            $event->addResponse(Response::msg($request->getSource(), "{$formated}"));
        });
    }

    /**
     * Returns the Plugin's name
     */
    public function getName() {
        return 'CoreCommands';
    }

}