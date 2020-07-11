<?php

namespace Tohur\Bot\Classes\Twitch;

use Tohur\Bot\Classes\Helpers\FunctionsClass;
use Tohur\Bot\Models\Commands;
use Tohur\Bot\Classes\Helpers\HelperClass;
use Tohur\Twitchirc\AbstractPlugin as BasePlugin;
use Tohur\Twitchirc\IRC\Response;

class CommandsPlugin extends BasePlugin
{


    /**
     * Does the 'heavy lifting' of initializing the plugin's behavior
     */
    public function init()
    {
            $this->bot->onChannel('/^!(.*)$/', function ($event) {
                $helper = new HelperClass();
                $request = $event->getRequest();
                $matches = $event->getMatches();
                $commandMatch = explode(' ', $matches[0], 3);

                $command = Commands::where('command', $commandMatch[0])->first();
                $replace = array(
                    '{$user}' => $helper->remove_hashtags($request->getSource()),
                    '{$title}' => '',
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
            });
    }

    /**
     * Returns the Plugin's name
     */
    public function getName()
    {
        return 'CommandsPlugin';
    }
}