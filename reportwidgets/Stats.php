<?php

namespace Tohur\Bot\ReportWidgets;

use Backend\Classes\ReportWidgetBase;
use Exception;
use Db;
use Tohur\SocialConnect\Classes\Apis\TwitchAPI;

class Stats extends ReportWidgetBase {

    public function render() {
        try {
            $this->loadData();
        } catch (Exception $ex) {
            $this->vars['error'] = $ex->getMessage();
        }

        return $this->makePartial('widget');
    }

    public function defineProperties() {
        return [
            'title' => [
                'title' => 'Widget title',
                'default' => 'Stats',
                'type' => 'string',
                'validationPattern' => '^.+$',
                'validationMessage' => 'The Widget Title is required.'
            ],
            'widgetHeight' => [
                'title' => 'Height',
                'default' => '200',
                'type' => 'string'
            ],
        ];
    }

    protected function loadData() {
        $twitch = new TwitchAPI();
        $Settings = \Tohur\Bot\Models\Settings::instance()->get('bot', []);
        $viewerscall = $twitch->getChatusers($Settings['Twitch']['channel']);

        $this->vars['viewers'] = $viewerscall;
    }

    protected function uptime() {
        $twitch = new TwitchAPI();
        $Settings = \Tohur\Bot\Models\Settings::instance()->get('bot', []);
        $apiCall = $twitch->getStream($Settings['Twitch']['channel']);

        if ($apiCall == null) {
            $uptime = 'You are offline';
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

    protected function viewercount() {
        $twitch = new TwitchAPI();
        $Settings = \Tohur\Bot\Models\Settings::instance()->get('bot', []);
        $apiCall = $twitch->getStream($Settings['Twitch']['channel']);
        if ($apiCall == null) {
            $viewercount = 'You are offline';
        } else {
            $viewercount = $apiCall[0]['viewer_count'];
        }
        return $viewercount;
    }

    protected function subcount() {
        $twitch = new TwitchAPI();
        $Settings = \Tohur\Bot\Models\Settings::instance()->get('bot', []);
        $user = $twitch->getUser($Settings['Twitch']['channel']);
        $channelID = $user[0]['id'];
        $findToken = \DB::table('tohur_bot_owners')->where('twitch_id', '=', $channelID)->get();
        $acessToken = $findToken[0]->twitch_token;
        $bot = true;
        $apiCall = $twitch->getSubcount($Settings['Twitch']['channel'],$acessToken, $bot = true);
        if ($apiCall == null) {
            $subcount = $channel . ' is offline';
        } else {
            $subcount = $apiCall - 1;
        }

        return $subcount;
    }

    protected function totalviews() {
        $twitch = new TwitchAPI();
        $Settings = \Tohur\Bot\Models\Settings::instance()->get('bot', []);
        $apiCall = $twitch->getUser($Settings['Twitch']['channel']);

        return $apiCall[0]['view_count'];
    }

    protected function hostcount() {
        $twitch = new TwitchAPI();
        $Settings = \Tohur\Bot\Models\Settings::instance()->get('bot', []);
        $apiCall = $twitch->hostscount($Settings['Twitch']['channel']);

        return $apiCall;
    }

    protected function followers() {
        $twitch = new TwitchAPI();
        $Settings = \Tohur\Bot\Models\Settings::instance()->get('bot', []);
        $apiCall = $twitch->getFollowcount($Settings['Twitch']['channel']);

        return $apiCall;
    }

    protected function title() {
        $twitch = new TwitchAPI();
        $Settings = \Tohur\Bot\Models\Settings::instance()->get('bot', []);
        $apiCall = $twitch->getChannelinfo($Settings['Twitch']['channel']);

        return $apiCall[0]['title'];
    }

    protected function game() {
        $twitch = new TwitchAPI();
        $Settings = \Tohur\Bot\Models\Settings::instance()->get('bot', []);
        $apiCall = $twitch->getChannelinfo($Settings['Twitch']['channel']);

        return $apiCall[0]['game_name'];
    }

    public function onUpdateStatsWidget() {
        return [
            '#' . $this->alias => $this->render()
        ];
    }

}
