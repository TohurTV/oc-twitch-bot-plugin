<?php namespace Tohur\Bot\Classes;

use Tohur\SocialConnect\Classes\Apis\TwitchAPI;

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

        // Opening the socket to the Rizon network
        $socket = fsockopen($config['serverHost'], $config['serverPort']);

        // Send auth info
        // fputs($socket, "PASS " . $password . "\n");
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
                    if ($command == ":!alive?") {
                        sleep(1);
                        fputs($socket, "PRIVMSG " . $ex[2] . " :whazzup? \n");
                    }
                    if ($command == ":!time") {
                        sleep(1);
                        fputs($socket, "PRIVMSG " . $ex[2] . " :" . date(DATE_RFC2822) . " \n");
                    }
                    if ($command == ":!help") {
                        sleep(1);
                        fputs($socket, "PRIVMSG " . $ex[2] . " :Tohur_Bot v0.1 commands. \n");
                        fputs($socket, "PRIVMSG " . $ex[2] . " :!alive?, !time, !slave, !chucknorris, !meme !meat \n");
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
                    if ($command == ":!test") {
                        sleep(1);
                        fputs($socket, "PRIVMSG " . $ex[2] . " :value0 " . $ex[0] . ", value1 " . $ex[1] . ",value2 " . $ex[2] . ",value3 " . $ex[3] . "\n");
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
                    if ($command == ":!meat") {
                        sleep(1);
                        $meat = file_get_contents('http://baconipsum.com/api/?type=all-meat&sentences=1');
                        $meat = explode(" ", $meat);
                        $meat = substr($meat['0'], 2);
                        fputs($socket, "PRIVMSG " . $ex[2] . " :" . $meat . " \n");
                    }
                }
            }
        }
    }

}

