<?php


namespace Tohur\Bot\Classes\Helpers;

use Illuminate\Http\Request;
use Tohur\Api\Classes\Helper;
use Tohur\Bot\Classes\Helpers\HelperClass;
use Tohur\SocialConnect\Classes\Apis\TwitchAPI;

class FunctionsClass
{
    function __construct()
    {
        $this->twitch = new TwitchAPI();
        $this->helper = new HelperClass();
    }

    function channelOwner($ex)
    {
        if (array_key_exists(2, $ex)) {
            $channelOwner = $this->helper->remove_hashtags($ex[2]);
        } else {
            $channelOwner = 'Empty';
        }
        return $channelOwner;
    }

    function channelTitle($ex)
    {
        if (array_key_exists(2, $ex)) {
            $apiCall = $this->twitch->getChannelinfo($this->channelOwner($ex));
            $title = $apiCall[0]['title'];
        } else {
            $title = 'Empty';
        }
        return $title;
    }

    function channelGame($ex)
    {
        if (array_key_exists(2, $ex)) {

            $apiCall = $this->twitch->getChannelinfo($this->channelOwner($ex));
            $game = $apiCall[0]['game_name'];

        } else {
            $game = 'Empty';
        }
        return $game;
    }

    function uptime($ex) {
        if (array_key_exists(2, $ex)) {
            $apiCall = $this->twitch->getStream($this->channelOwner($ex));

            if ($apiCall == null) {
                $text = $this->channelOwner($ex) . ' is offline';
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
        } else {
            $text = 'Empty';
        }
        return $text;
    }

    function targetUser($ex)
    {
        if (array_key_exists(4, $ex)) {
            $targetUser = $this->helper->remove_underscores($ex[4]);
        } else {
            $targetUser = 'Empty';
        }
        return $targetUser;
    }

    function targetUserGame($ex)
    {
        if (array_key_exists(4, $ex)) {

            $apiCall = $this->twitch->getChannelinfo($this->targetUser($ex));
            $targetUserGame = $apiCall[0]['game_name'];

        } else {
            $targetUserGame = 'Empty';
        }
        return $targetUserGame;
    }
}