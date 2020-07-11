<?php

namespace Tohur\Bot\Classes;

use Tohur\Bot\Classes\FunctionsClass;
use Tohur\Bot\Models\Commands;
use Tohur\Bot\Classes\HelperClass;
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
                $message = explode(' ', $matches[0], 3);

                $command = Commands::where('command', $message[0])->first();
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