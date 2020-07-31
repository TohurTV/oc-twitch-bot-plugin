<?php

namespace Tohur\Bot\Classes\Twitch;

use Tohur\Bot\Classes\Helpers\FunctionsClass;
use Tohur\Bot\Models\CustomCommands as CommandDB;
use Tohur\Bot\Classes\Helpers\HelperClass;
use Tohur\Bot\Models\Users;
use Tohur\Bot\Models\Points;
use Tohur\Twitchirc\AbstractPlugin as BasePlugin;
use Tohur\Twitchirc\IRC\Response;
use Tohur\Bot\Classes\Helpers\BotBlacklist;

class UserTracking extends BasePlugin {

    /**
     * Does the 'heavy lifting' of initializing the plugin's behavior
     */
    public function init() {
        $this->bot->onChannel('/^(.*)$/', function ($event) {
            $Settings = \Tohur\Bot\Models\Settings::instance()->get('bot', []);
            $helper = new HelperClass();
            $function = new FunctionsClass();
            $bot = BotBlacklist::$bots;

            $request = $event->getRequest();
            $matches = $event->getMatches();
            $channel = $helper->remove_hashtags($request->getSource());
            $chatter = $helper->remove_hashtags($request->getSendingUser());
            $userId = $function->userid($chatter);

// Create User in Database if not 
            $findchatter = Users::firstOrCreate(['channel' => $channel, 'twitch_id' => $userId, 'twitch' => $chatter]);
            $user = Users::where('channel', $channel)
                    ->where('twitch_id', $userId)
                    ->where('twitch', $chatter)
                    ->first();

            if ($user->totalmessages == null) {
                $messagecount = 1;
            } else {
                $amountOne = $user->totalmessages;
                $amountTwo = 1;
                $messagecount = $amountTwo + $amountOne;
            }

            if ($user->points == null) {
                $pointcount = $Settings['Points']['pointspermessage'];
            } else {
                $amountOne = $user->points;
                $amountTwo = $Settings['Points']['pointspermessage'];
                $pointcount = $amountTwo + $amountOne;
            }
            if (in_array($chatter, $bot)) {
                $update = Users::where('channel', $channel)
                        ->where('twitch_id', $userId)
                        ->where('twitch', $chatter)
                        ->update(['totalmessages' => $messagecount, 'lastseen' => now()]);
            }
            elseif ($user->ignore == true) {
                $update = Users::where('channel', $channel)
                        ->where('twitch_id', $userId)
                        ->where('twitch', $chatter)
                        ->update(['totalmessages' => $messagecount, 'lastseen' => now()]);
            } else {
                $update = Users::where('channel', $channel)
                        ->where('twitch_id', $userId)
                        ->where('twitch', $chatter)
                        ->update(['points' => $pointcount, 'totalmessages' => $messagecount, 'lastseen' => now()]);
            }
        });
    }

    /**
     * Returns the Plugin's name
     */
    public function getName() {
        return 'UserTracking';
    }

}
