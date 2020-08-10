<?php

namespace Tohur\Bot\Console;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Tohur\Bot\Classes\TwitchBotClass;
use Tohur\Bot\Models\Users;
use Tohur\Bot\Models\Roles;
use Tohur\SocialConnect\Classes\Apis\TwitchAPI;
use Tohur\Bot\Classes\Helpers\BotBlacklist;

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
        $bot = BotBlacklist::$bots;
        $twitchuser = $twitch->getUser($Settings['Twitch']['channel']);
        $channel = $twitchuser[0]['id'];
        $findToken = \DB::table('tohur_bot_owners')->where('twitch_id', '=', $channel)->get();
        $acessToken = $findToken[0]->twitch_token;

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
            $broadcasterrole = Roles::where('code', 'broadcaster')->first();
            if ($user->inRole($broadcasterrole)) {
                // User is in Role
            } else {
                $user->roles()->add($broadcasterrole);
                $user->save();
            }
            $viewerrole = Roles::where('code', 'viewer')->first();
            if ($user->inRole($viewerrole)) {
                // User is in Role
            } else {
                $user->roles()->add($viewerrole);
                $user->save();
            }
            $subcriberCall = $twitch->getSubstatus($Settings['Twitch']['channel'], $broadcaster, $acessToken, $bot = true);
            if ($subcriberCall == null) {
                $subcriberrole = Roles::where('code', 'subcriber')->first();
                if ($user->inRole($subcriberrole)) {
                    $user->roles()->detach($subcriberrole);
                    $user->save();
                } else {
                    // User is not in Role... Push to Array
                }
            } else {
                $subcriberrole = Roles::where('code', 'subcriber')->first();
                if ($user->inRole($subcriberrole)) {
                    // User is in Role... Push to Array
                } else {
                    $user->roles()->add($subcriberrole);
                    $user->save();
                }
            }
            $followerCall = $twitch->getFollowRelationship($Settings['Twitch']['channel'], $broadcaster);
            if ($followerCall == null) {
                $followerrole = Roles::where('code', 'follower')->first();
                if ($user->inRole($followerrole)) {
                    $user->roles()->detach($followerrole);
                    $user->save();
                } else {
                    // User is not in Role... Push to Array
                }
            } else {
                $followerrole = Roles::where('code', 'follower')->first();
                if ($user->inRole($followerrole)) {
                    // User is in Role... Push to Array
                } else {
                    $user->roles()->add($followerrole);
                    $user->save();
                }
            }
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
                if (in_array($broadcaster, $bot)) {
                    echo 'User is Bot';
                } elseif ($user->ignore == true) {
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

            $viprole = Roles::where('code', 'vip')->first();
            if ($user->inRole($viprole)) {
                // User is in Role
            } else {
                $user->roles()->add($viprole);
                $user->save();
            }
            $viewerrole = Roles::where('code', 'viewer')->first();
            if ($user->inRole($viewerrole)) {
                // User is in Role
            } else {
                $user->roles()->add($viewerrole);
                $user->save();
            }
            $subcriberCall = $twitch->getSubstatus($Settings['Twitch']['channel'], $vip, $acessToken, $bot = true);
            if ($subcriberCall == null) {
                $subcriberrole = Roles::where('code', 'subcriber')->first();
                if ($user->inRole($subcriberrole)) {
                    $user->roles()->detach($subcriberrole);
                    $user->save();
                } else {
                    // User is not in Role... Push to Array
                }
            } else {
                $subcriberrole = Roles::where('code', 'subcriber')->first();
                if ($user->inRole($subcriberrole)) {
                    // User is in Role... Push to Array
                } else {
                    $user->roles()->add($subcriberrole);
                    $user->save();
                }
            }
            $followerCall = $twitch->getFollowRelationship($Settings['Twitch']['channel'], $vip);
            if ($followerCall == null) {
                $followerrole = Roles::where('code', 'follower')->first();
                if ($user->inRole($followerrole)) {
                    $user->roles()->detach($followerrole);
                    $user->save();
                } else {
                    // User is not in Role... Push to Array
                }
            } else {
                $followerrole = Roles::where('code', 'follower')->first();
                if ($user->inRole($followerrole)) {
                    // User is in Role... Push to Array
                } else {
                    $user->roles()->add($followerrole);
                    $user->save();
                }
            }
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
                if (in_array($vip, $bot)) {
                    echo 'User is Bot';
                } elseif ($user->ignore == true) {
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

            $moderatorrole = Roles::where('code', 'moderator')->first();
            if ($user->inRole($moderatorrole)) {
                // User is in Role
            } else {
                $user->roles()->add($moderatorrole);
                $user->save();
            }
            $viewerrole = Roles::where('code', 'viewer')->first();
            if ($user->inRole($viewerrole)) {
                // User is in Role
            } else {
                $user->roles()->add($viewerrole);
                $user->save();
            }
            $subcriberCall = $twitch->getSubstatus($Settings['Twitch']['channel'], $moderator, $acessToken, $bot = true);
            if ($subcriberCall == null) {
                $subcriberrole = Roles::where('code', 'subcriber')->first();
                if ($user->inRole($subcriberrole)) {
                    $user->roles()->detach($subcriberrole);
                    $user->save();
                } else {
                    // User is not in Role... Push to Array
                }
            } else {
                $subcriberrole = Roles::where('code', 'subcriber')->first();
                if ($user->inRole($subcriberrole)) {
                    // User is in Role... Push to Array
                } else {
                    $user->roles()->add($subcriberrole);
                    $user->save();
                }
            }
            $followerCall = $twitch->getFollowRelationship($Settings['Twitch']['channel'], $moderator);
            if ($followerCall == null) {
                $followerrole = Roles::where('code', 'follower')->first();
                if ($user->inRole($followerrole)) {
                    $user->roles()->detach($followerrole);
                    $user->save();
                } else {
                    // User is not in Role... Push to Array
                }
            } else {
                $followerrole = Roles::where('code', 'follower')->first();
                if ($user->inRole($followerrole)) {
                    // User is in Role... Push to Array
                } else {
                    $user->roles()->add($followerrole);
                    $user->save();
                }
            }
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
                if (in_array($moderator, $bot)) {
                    echo 'User is Bot';
                } elseif ($user->ignore == true) {
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

            $viewerrole = Roles::where('code', 'viewer')->first();
            if ($user->inRole($viewerrole)) {
                // User is in Role
            } else {
                $user->roles()->add($viewerrole);
                $user->save();
            }

            $subcriberCall = $twitch->getSubstatus($Settings['Twitch']['channel'], $viewer, $acessToken, $bot = true);
            if ($subcriberCall == null) {
                $subcriberrole = Roles::where('code', 'subcriber')->first();
                if ($user->inRole($subcriberrole)) {
                    $user->roles()->detach($subcriberrole);
                    $user->save();
                } else {
                    // User is not in Role... Push to Array
                }
            } else {
                $subcriberrole = Roles::where('code', 'subcriber')->first();
                if ($user->inRole($subcriberrole)) {
                    // User is in Role... Push to Array
                } else {
                    $user->roles()->add($subcriberrole);
                    $user->save();
                }
            }
            $followerCall = $twitch->getFollowRelationship($Settings['Twitch']['channel'], $viewer);
            if ($followerCall == null) {
                $followerrole = Roles::where('code', 'follower')->first();
                if ($user->inRole($followerrole)) {
                    $user->roles()->detach($followerrole);
                    $user->save();
                } else {
                    // User is not in Role... Push to Array
                }
            } else {
                $followerrole = Roles::where('code', 'follower')->first();
                if ($user->inRole($followerrole)) {
                    // User is in Role... Push to Array
                } else {
                    $user->roles()->add($followerrole);
                    $user->save();
                }
            }
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
                if (in_array($viewer, $bot)) {
                    echo 'User is Bot';
                } elseif ($user->ignore == true) {
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
