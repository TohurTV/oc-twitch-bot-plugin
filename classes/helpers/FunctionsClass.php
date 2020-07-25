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
        $this->settings = \Tohur\Bot\Models\Settings::instance()->get('bot', []);
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

    function viewers($channel) {

        $apiCall = $this->twitch->getStream($channel);
        if ($apiCall == null) {
            $viewercount = $channel . ' is offline';
        } else {
            $viewercount = $apiCall[0]['viewer_count'];
        }

        return $viewercount;
    }

    function subcount($channel) {
        $user = $this->twitch->getUser($channel);
        $channelID = $user[0]['id'];
        $findToken = \DB::table('tohur_bot_owners')->where('twitch_id', '=', $channelID)->get();
        $acessToken = $findToken[0]->twitch_token;
        $apiCall = $this->twitch->getSubcount($channel, $acessToken, $bot = true);
        if ($apiCall == null) {
            $subcount = $channel . ' is offline';
        } else {
            $subcount = $apiCall;
        }

        return $subcount;
    }

    function followage($targetUser) {

        $apiCall = $this->twitch->getFollowRelationship($this->settings['Twitch']['channel'], $targetUser);
        if ($apiCall == null) {
            $followage = $targetUser . ' is not following';
        } else {

            $time1 = new \DateTime($apiCall[0]['followed_at']); // Event occurred time
            $time2 = new \DateTime(date('Y-m-d H:i:s')); // Current time
            $interval = $time1->diff($time2);

            $followage = $interval->y . " Years, " . $interval->m . " Months, " . $interval->d . " Days ";
        }

        return $followage;
    }

    function followcount($channel) {

        $twitch = new TwitchAPI();
        $apiCall = $twitch->getFollowcount($channel);

        return $apiCall;
    }

    function uptime($channel) {

        $apiCall = $this->twitch->getStream($channel);

        if ($apiCall == null) {
            $uptime = $channel . ' is offline';
        } else {

            $time1 = new \DateTime($apiCall[0]['started_at']); // Event occurred time
            $time2 = new \DateTime(date('Y-m-d H:i:s')); // Current time
            $interval = $time1->diff($time2);
            if ($interval->h == '00') {
                $uptime = $interval->i . " Mintues ";
            } elseif ($interval->h == '01') {
                $uptime = $interval->y . $interval->h . " Hour, " . $interval->i . " Mintues ";
            } else {
                $uptime = $interval->y . $interval->h . " Hours, " . $interval->i . " Mintues ";
            }
        }

        return $uptime;
    }

    function userid($channel) {
        $user = $this->twitch->getUser($channel);
        $userID = $user[0]['id'];

        return $userID;
    }

}
