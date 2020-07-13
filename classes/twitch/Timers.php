<?php

namespace Tohur\Bot\Classes\Twitch;

use Tohur\Bot\Classes\Helpers\FunctionsClass;
use Tohur\Bot\Classes\Helpers\HelperClass;
use Tohur\Twitchirc\IRC\Response;
use Tohur\Twitchirc\Twitchirc;

class Timers
{
        function __construct($config)
        {
            $this->run($config);
        }

        function run($config)
        {
            $bot = new Twitchirc($config);


            $bot->run();
        }
    }
