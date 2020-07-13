<?php namespace Tohur\Bot\Classes;

use Tohur\Bot\Classes\Twitch\Commands;
use Tohur\Twitchirc\Twitchirc;
use Tohur\Twitchirc\IRC\Response;

class TwitchBotClass
{

    function __construct($config)
    {
        $this->run($config);
    }

    function run($config)
    {
        $bot = new Twitchirc($config);

        $bot->loadPlugins(array(
            new Commands($bot),
        ));
        $bot->run();
    }
}

