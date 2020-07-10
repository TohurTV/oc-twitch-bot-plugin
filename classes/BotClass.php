<?php namespace Tohur\Bot\Classes;


use Tohur\SocialConnect\Classes\Apis\TwitchAPI;
use Tohur\Bot\Classes\CommandsClass;
use Tohur\Bot\Classes\TimersClass;

set_time_limit(0);

class BotClass
{

    function __construct($config)
    {
        $this->run($config);
    }

    function run($config)
    {
        // Change these values!
        $channels = $config['serverChannels'];
        // $password = 'secret';
        $master = $config['master'];

        // Opening the socket to the Twitch IRC network
        $socket = fsockopen($config['serverHost'], $config['serverPort']);

        // Send auth info
        fputs($socket, "PASS " . $config['pass'] . "\n");
        fputs($socket, "NICK " . $config['nick'] . "\n");

        // Join channel
        foreach ($channels as $channel) {
            fputs($socket, "JOIN " . $channel . "\n");
        }
        // Force an endless while
        while (1) {
            // Continue the rest of the script here
            while ($data = fgets($socket, 128)) {
                echo $data;
                flush();

                // Separate all data
                $ex = explode(' ', $data);

                // Send PONG back to the server
                if ($ex[0] == "PING") {
                    fputs($socket, "PONG " . $ex[1] . "\n");
                }

                // executes chat command
                if ($ex[0] != 'PING' && isset($ex[3])) {
                    $command = str_replace(array(
                        chr(10),
                        chr(13)
                    ), '', $ex[3]);

                    $commands = New CommandsClass($socket, $ex, $config);
//                    $timers = New TimersClass($socket, $ex, $config);
                }
            }
        }
    }
}

