<?php

namespace Tohur\Bot\Classes\Helpers;

use Illuminate\Http\Request;
use Tohur\Api\Classes\Helper;
use Tohur\Bot\Classes\Helpers\HelperClass;
use Tohur\SocialConnect\Classes\Apis\TwitchAPI;

class FunctionsClass {

    function __construct() {
        $this->twitch = new TwitchAPI();
        $this->helper = new HelperClass();
    }

    function channelTitle($channel) {

        $apiCall = $this->twitch->getChannelinfo($channel);
        $title = $apiCall[0]['title'];

        return $title;
    }

    function channelGame($channel) {

        $apiCall = $this->twitch->getChannelinfo($channel);
        $game = $apiCall[0]['game_name'];

        return $game;
    }

    function uptime($channel) {

        $apiCall = $this->twitch->getStream($channel);

        if ($apiCall == null) {
            $text = $channel . ' is offline';
        } else {

            $time1 = new \DateTime($apiCall[0]['started_at']); // Event occurred time
            $time2 = new \DateTime(date('Y-m-d H:i:s')); // Current time
            $interval = $time1->diff($time2);
            if ($interval->h == '00') {
                $text = $interval->i . " Mintues ";
            } else {
                $text = $interval->y . $interval->h . " Hours, " . $interval->i . " Mintues ";
            }
        }

        return $text;
    }

    function targetUser($channel) {

        $targetUser = $this->helper->remove_underscores($channel);

        return $targetUser;
    }

    function targetUserGame($channel) {

        $apiCall = $this->twitch->getChannelinfo($channel);
        $targetUserGame = $apiCall[0]['game_name'];

        return $targetUserGame;
    }

}
