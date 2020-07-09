<?php


namespace Tohur\Bot\Classes;


use Tohur\Bot\Classes\HelperClass;
use Tohur\Bot\Classes\FunctionsClass;
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
                    $functions = new FunctionsClass();
                    $parts = explode("!", $ex[0]);
                    $user = substr($parts['0'], 1);

                    $replace = array(
                        '{$user}' => $functions->channelOwner($ex),
                        '{$title}' => $functions->channelTitle($ex),
                        '{$usergame}' => $functions->channelGame($ex),
                        '{$uptime}' => $functions->uptime($ex),
                        '{$targetuser}' => $functions->targetUser($ex),
                        '{$targetusergame}' => $functions->targetUserGame($ex)
                    );
                    $formated = strtr($commandDB->response, $replace);
                    sleep(1);
                    fputs($socket, "PRIVMSG " . $ex[2] . " :" . $formated . " \n");

                }

            }
        }
    }
}