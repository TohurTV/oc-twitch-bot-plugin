<?php


namespace Tohur\Bot\Classes;


use Tohur\Bot\Classes\HelperClass;
use Tohur\SocialConnect\Classes\Apis\TwitchAPI;


class CommandsClass
{
    function __construct($socket, $ex)
    {
        $this->commands($socket, $ex);
    }

    function commands($socket, $ex)
    {
        if ($ex[0] != 'PING' && isset($ex[3])) {
            $command = str_replace(array(
                chr(10),
                chr(13)
            ), '', $ex[3]);
            $commandsDB = \DB::table('tohur_bot_commands')->get();
            foreach ($commandsDB as $commandDB) {
                if ($command == ":!" . $commandDB->command) {
                    $twitch = new TwitchAPI();
                    $helper = new HelperClass();
                    $parts = explode("!", $ex[0]);
                    $user = substr($parts['0'], 1);
                    if (array_key_exists(2, $ex)) {
                        $channelOwner = $helper->remove_hashtags($ex[2]);
                    } else {
                        $channelOwner = 'Empty';
                    }
                    if (array_key_exists(2, $ex)) {
                        $apiCall = $twitch->getChannelinfo($channelOwner);
                        $title = $apiCall[0]['title'];
                    } else {
                        $title = 'Empty';
                    }
                    if (array_key_exists(4, $ex)) {
                        $targetUser = $helper->remove_underscores($ex[4]);
                    } else {
                        $targetUser = 'Empty';
                    }
                    if (array_key_exists(4, $ex)) {

                        $apiCall = $twitch->getChannelinfo($targetUser);
                        $targetUserGame = $apiCall[0]['game_name'];

                    } else {
                        $targetUserGame = 'Empty';
                    }

                    $replace = array(
                        '{$user}' => $channelOwner,
                        '{$title}' => $title,
                        '{$targetuser}' => $targetUser,
                        '{$targetusergame}' => $targetUserGame
                    );
                    $formated = strtr($commandDB->response, $replace);
                    sleep(1);
                    fputs($socket, "PRIVMSG " . $ex[2] . " :" . $formated . " \n");

                }

            }
        }
    }
}