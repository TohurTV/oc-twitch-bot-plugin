<?php namespace Tohur\Bot\Classes;

use Tohur\Bot\Classes\CommandsPlugin;
use Tohur\Bot\Classes\DiscordPlugin;
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
            new CommandsPlugin($bot),
        ));
        $bot->run();
    }
}

