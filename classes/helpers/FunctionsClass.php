<?php

namespace Tohur\Bot\Classes\Helpers;

use Illuminate\Http\Request;
use Tohur\Api\Classes\Helper;
use Tohur\Bot\Classes\Helpers\HelperClass;
use Tohur\SocialConnect\Classes\Apis\TwitchAPI;
use Tohur\Bot\Models\Users;

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

    function channelGameImage($channel) {

        $game = $this->twitch->getChannelinfo($channel);
        $gameimage1 = "https://static-cdn.jtvnw.net/ttv-boxart/";
        $gameimage2 = str_replace(' ', '%20', $game[0]['game_name']);
        $gameimage3 = "-600x800.jpg";
        $gameimage = $gameimage1 . $gameimage2 . $gameimage3;
        return $gameimage;
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

    function totalviews($channel) {
        $apiCall = $this->twitch->getUser($channel);

        return $apiCall[0]['view_count'];
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
            $subcount = $apiCall - 1;
        }

        return $subcount;
    }

    function hostcount($channel) {

        $apiCall = $this->twitch->hostscount($channel);

        return $apiCall;
    }

    function followage($targetUser) {

        $apiCall = $this->twitch->getFollowRelationship($this->settings['Twitch']['channel'], $targetUser);
        if ($apiCall == null) {
            $followage = $targetUser . ' is not following';
        } else {

            $followage = $this->helper->converttime($apiCall[0]['followed_at']);
        }

        return $followage;
    }

    function accountage($targetUser) {
        $user = $this->twitch->getUser($targetUser);
        $userID = $user[0]['id'];
        $apiCall = $this->twitch->krakengetUser($userID);
        if ($apiCall == null) {
            $accountage = $targetUser . ' is not following';
        } else {

            $accountage = $this->helper->converttime($apiCall['created_at']);
        }

        return $accountage;
    }

    function lastseen($channel, $targetUser) {

        $twitchuser = $this->twitch->getUser($channel);
        $userID = $twitchuser[0]['id'];

        $user = Users::where('channel', $channel)
                ->where('twitch', $targetUser)
                ->first();

        if ($user->lastseen == null) {
            $lastseen = $targetUser . ' has not been in chat';
        } else {

            $lastseen = $this->helper->converttime($user->lastseen);
        }

        return $lastseen;
    }

    function watchtime($channel, $targetUser) {

        $user = Users::where('channel', $channel)
                ->where('twitch', $targetUser)
                ->first();
        if ($user->watchtime == null) {
            $watchtime = $targetUser . ' has no watchtime';
        } else {
            $watchtime = $this->helper->converttime($user->watchtime);
        }

        return $watchtime;
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

            $uptime = $this->helper->convertuptime($apiCall[0]['started_at']);
        }

        return $uptime;
    }

    function userid($channel) {
        $user = $this->twitch->getUser($channel);
        $userID = $user[0]['id'];

        return $userID;
    }

}
