<?php

namespace Tohur\Bot\Classes\Twitch;

use Tohur\Bot\Classes\Helpers\FunctionsClass;
use Tohur\Bot\Models\CustomCommands as CommandDB;
use Tohur\Bot\Classes\Helpers\HelperClass;
use Tohur\Twitchirc\AbstractPlugin as BasePlugin;
use Tohur\Twitchirc\IRC\Response;

class CustomCommands extends BasePlugin {

    /**
     * Does the 'heavy lifting' of initializing the plugin's behavior
     */
    public function init() {
        $this->bot->onChannel('/^!(.*)$/', function ($event) {
            $helper = new HelperClass();
            $request = $event->getRequest();
            $matches = $event->getMatches();
            $match = implode(' ', $matches);
            $commandMatch = explode(' ', $match, 3);

            $command = CommandDB::where('command', $commandMatch[0])->first();
            if (empty($command)) {
                
            } else {
                $replace = array(
                    '{$user}' => $helper->remove_hashtags($request->getSource()),
                    '{$usertitle}' => '',
                    '{$usergame}' => '',
                    '{$uptime}' => '',
                    '{$targetuser}' => '',
                    '{$targetusergame}' => '',
                    '{$echo}' => trim($matches[0]),
                );
                $formated = strtr($command->response, $replace);
                sleep(1);
                $event->addResponse(
                        Response::msg($request->getSource(), "{$formated}")
                );
            }
        });
    }

    /**
     * Returns the Plugin's name
     */
    public function getName() {
        return 'Commands';
    }

}
