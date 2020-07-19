<?php namespace Tohur\Bot\Classes;

use Tohur\Bot\Classes\Twitch\CoreCommands;
use Tohur\Bot\Classes\Twitch\CustomCommands;
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
            new CoreCommands($bot),
            new CustomCommands($bot),
        ));
        $bot->run();
    }
}

