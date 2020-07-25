<?php

namespace Tohur\Bot\Console;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Tohur\Bot\Classes\TwitchBotClass;
use Tohur\Bot\Models\Users;
use Tohur\SocialConnect\Classes\Apis\TwitchAPI;

class TwitchBotUsers extends Command {

    /**
     * @var string The console command name.
     */
    protected $name = 'bot:twitchchatusers';

    /**
     * @var string The console command description.
     */
    protected $description = 'No description provided yet...';

    public function __construct() {
        parent::__construct();
    }

    /**
     * Execute the console command.
     * @return void
     */
    public function handle() {
        $twitch = new TwitchAPI();
        $Settings = \Tohur\Bot\Models\Settings::instance()->get('bot', []);
        $viewerscall = $twitch->getChatusers($Settings['Twitch']['channel']);

        foreach ($viewerscall->chatters->broadcaster as $obj) {
            $broadcaster = $obj;
            $userid = $twitch->getUser($broadcaster);
            $channelID = $userid[0]['id'];
            // Create User in Database if not found
            $broadcasteruser = Users::firstOrCreate(['channel' => $Settings['Twitch']['channel'], 'twitch_id' => $channelID, 'twitch' => $broadcaster]);

            $user = Users::where('channel', $Settings['Twitch']['channel'])
                    ->where('twitch_id', $channelID)
                    ->where('twitch', $broadcaster)
                    ->first();

            if ($user->watchtime == null) {
                $watchmins = 1;
            } else {
                $amountOne = $user->watchtime;
                $amountTwo = 1;
                $watchmins = $amountTwo + $amountOne;
            }

            if ($user->points == null) {
                $pointcount = $Settings['Points']['pointspermin'];
            } else {
                $amountOne = $user->points;
                $amountTwo = $Settings['Points']['pointspermin'];
                $pointcount = $amountTwo + $amountOne;
            }
            if ($twitch->isChannelLive($Settings['Twitch']['channel']) == true) {
                if ($user->ignore == true) {
                    echo 'User is ignored';
                } else {

                    $update = Users::where('channel', $Settings['Twitch']['channel'])
                            ->where('twitch_id', $channelID)
                            ->where('twitch', $broadcaster)
                            ->update(['points' => $pointcount, 'watchtime' => $watchmins]);
                }
            }
        }
        foreach ($viewerscall->chatters->vips as $obj) {
            $vip = $obj;
            $userid = $twitch->getUser($vip);
            $channelID = $userid[0]['id'];
            // Create User in Database if not found
            $vipsuser = Users::firstOrCreate(['channel' => $Settings['Twitch']['channel'], 'twitch_id' => $channelID, 'twitch' => $vip]);

            $user = Users::where('channel', $Settings['Twitch']['channel'])
                    ->where('twitch_id', $channelID)
                    ->where('twitch', $vip)
                    ->first();

            if ($user->watchtime == null) {
                $watchmins = 1;
            } else {
                $amountOne = $user->watchtime;
                $amountTwo = 1;
                $watchmins = $amountTwo + $amountOne;
            }

            if ($user->points == null) {
                $pointcount = $Settings['Points']['pointspermin'];
            } else {
                $amountOne = $user->points;
                $amountTwo = $Settings['Points']['pointspermin'];
                $pointcount = $amountTwo + $amountOne;
            }
            if ($twitch->isChannelLive($Settings['Twitch']['channel']) == true) {
                if ($user->ignore == true) {
                    echo 'User is ignored';
                } else {
                    $update = Users::where('channel', $Settings['Twitch']['channel'])
                            ->where('twitch_id', $channelID)
                            ->where('twitch', $vip)
                            ->update(['points' => $pointcount, 'watchtime' => $watchmins]);
                }
            }
        }
        foreach ($viewerscall->chatters->moderators as $obj) {
            $moderator = $obj;
            $userid = $twitch->getUser($moderator);
            $channelID = $userid[0]['id'];
            // Create User in Database if not found
            $moderatorsuser = Users::firstOrCreate(['channel' => $Settings['Twitch']['channel'], 'twitch_id' => $channelID, 'twitch' => $moderator]);

            $user = Users::where('channel', $Settings['Twitch']['channel'])
                    ->where('twitch_id', $channelID)
                    ->where('twitch', $moderator)
                    ->first();

            if ($user->watchtime == null) {
                $watchmins = 1;
            } else {
                $amountOne = $user->watchtime;
                $amountTwo = 1;
                $watchmins = $amountTwo + $amountOne;
            }

            if ($user->points == null) {
                $pointcount = $Settings['Points']['pointspermin'];
            } else {
                $amountOne = $user->points;
                $amountTwo = $Settings['Points']['pointspermin'];
                $pointcount = $amountTwo + $amountOne;
            }
            if ($twitch->isChannelLive($Settings['Twitch']['channel']) == true) {
                if ($user->ignore == true) {
                    echo 'User is ignored';
                } else {
                    $update = Users::where('channel', $Settings['Twitch']['channel'])
                            ->where('twitch_id', $channelID)
                            ->where('twitch', $moderator)
                            ->update(['points' => $pointcount, 'watchtime' => $watchmins]);
                }
            }
        }
        foreach ($viewerscall->chatters->viewers as $obj) {
            $viewer = $obj;
            $userid = $twitch->getUser($viewer);
            $channelID = $userid[0]['id'];
            // Create User in Database if not found
            $viewersuser = Users::firstOrCreate(['channel' => $Settings['Twitch']['channel'], 'twitch_id' => $channelID, 'twitch' => $viewer]);


            $user = Users::where('channel', $Settings['Twitch']['channel'])
                    ->where('twitch_id', $channelID)
                    ->where('twitch', $viewer)
                    ->first();

            if ($user->watchtime == null) {
                $watchmins = 1;
            } else {
                $amountOne = $user->watchtime;
                $amountTwo = 1;
                $watchmins = $amountTwo + $amountOne;
            }

            if ($user->points == null) {
                $pointcount = $Settings['Points']['pointspermin'];
            } else {
                $amountOne = $user->points;
                $amountTwo = $Settings['Points']['pointspermin'];
                $pointcount = $amountTwo + $amountOne;
            }
            if ($twitch->isChannelLive($Settings['Twitch']['channel']) == true) {
                if ($user->ignore == true) {
                    echo 'User is ignored';
                } else {
                    $update = Users::where('channel', $Settings['Twitch']['channel'])
                            ->where('twitch_id', $channelID)
                            ->where('twitch', $viewer)
                            ->update(['points' => $pointcount, 'watchtime' => $watchmins]);
                }
            }
        }
    }

    /**
     * Get the console command arguments.
     * @return array
     */
    protected function getArguments() {
        return [];
    }

    /**
     * Get the console command options.
     * @return array
     */
    protected function getOptions() {
        return [];
    }

}
