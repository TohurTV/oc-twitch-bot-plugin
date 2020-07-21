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
            $function = new FunctionsClass();
            $request = $event->getRequest();
            $matches = $event->getMatches();
            $match = implode(' ', $matches);
            $commandMatch = explode(' ', $match, 3);

            $command = CommandDB::where('command', $commandMatch[0])->first();
            if (empty($command)) {
                
            } else {
                if (empty($commandMatch[1])) {
                    $targetUser = $request->getSendingUser();
                } else {
                    $targetUser = trim($commandMatch[1]);
                }
                $replace = array(
                    '{$user}' => $helper->remove_hashtags($request->getSource()),
                    '{$userurl}' => 'https://twitch.tv/'.$helper->remove_hashtags($request->getSource()),
                    '{$usertitle}' => $function->channelTitle($helper->remove_hashtags($request->getSource())),
                    '{$usergame}' => $function->channelGame($helper->remove_hashtags($request->getSource())),
                    '{$userviewers}' => $function->viewers($helper->remove_hashtags($request->getSource())),
                    '{$uptime}' => $function->uptime($helper->remove_hashtags($request->getSource())),
                    '{$targetuser}' => $targetUser,
                    '{$targetuserurl}' => 'https://twitch.tv/'.$targetUser,
                    '{$targetusertitle}' => $function->channelTitle($targetUser),
                    '{$targetusergame}' => $function->channelGame($targetUser),
                    '{$targetuserviewers}' => $function->viewers($targetUser),
                );
                $formated = strtr($command->response, $replace);
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
