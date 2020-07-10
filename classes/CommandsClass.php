<?php


namespace Tohur\Bot\Classes;

use Tohur\Bot\Classes\FunctionsClass;
use Tohur\Bot\Models\Commands;

class CommandsClass
{
    function __construct($socket, $ex, $config)
    {
        $this->commands($socket, $ex, $config);
    }

    function commands($socket, $ex, $config)
    {
        $master = $config['master'];
        if ($ex[0] != 'PING' && isset($ex[3])) {
            $command = str_replace(array(
                chr(10),
                chr(13)
            ), '', $ex[3]);
            if ($command == ":!alive?") {
                sleep(1);
                fputs($socket, "PRIVMSG " . $ex[2] . " :whazzup? \n");
            }
            if ($command == ":!time") {
                sleep(1);
                fputs($socket, "PRIVMSG " . $ex[2] . " :" . date(DATE_RFC2822) . " \n");
            }

            if ($command == ":!slave") {
                sleep(1);
                $parts = explode("!", $ex[0]);
                $user = substr($parts['0'], 1);

                if ($user == $master)
                    fputs($socket, "PRIVMSG " . $ex[2] . " :Yes master! \n");
                else
                    fputs($socket, "PRIVMSG " . $ex[2] . " :get lost " . $user . " you filthy infidel! \n");
            }
            if ($command == ":!testinfo") {
                sleep(1);
                fputs($socket, "PRIVMSG " . $ex[2] . " :value0 " . $ex[0] . ", value1 " . $ex[1] . ",value2 " . $ex[2] . ",value3 " . $ex[3] . ",value4 " . $ex[4] . "\n");
            }
            if ($command == ":!chucknorris") {
                sleep(1);
                $joke = json_decode(file_get_contents('http://api.icndb.com/jokes/random', true));
                fputs($socket, "PRIVMSG " . $ex[2] . " :" . $joke->value->joke . " \n");
            }
            if ($command == ":!shutdown") {
                sleep(1);
                $meme = file_get_contents('http://test.com');
                if ($user == $master)
                    fputs($socket, "PRIVMSG " . $ex[2] . " :" . $meme . " \n");
                else
                    fputs($socket, "PRIVMSG " . $ex[2] . " :get lost " . $user . " you filthy infidel! \n");
            }
            $commandsDB = Commands::all();
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