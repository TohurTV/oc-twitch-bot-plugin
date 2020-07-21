<?php

namespace Tohur\Bot;

use App;
use Auth;
use Backend\Widgets\Form;
use Carbon\Carbon;
use Event;
use Backend;
use System\Classes\PluginBase;
use System\Classes\SettingsManager;
use Illuminate\Foundation\AliasLoader;
use Tohur\Bot\Models\Owner;
use Tohur\Bot\Models\TimerGroups;
use Tohur\Bot\Models\Timers;
use Tohur\Bot\Classes\Twitch\Timers as BotTimers;
use Tohur\Bot\Models\Users;
use RestCord\DiscordClient;
use Tohur\SocialConnect\Classes\Apis\TwitchAPI;

class Plugin extends PluginBase {

    // Make this plugin run on updates page
    public $elevated = true;
    public $require = ['Tohur.SocialConnect'];

    /**
     * Returns information about this plugin.
     *
     * @return array
     */
    public function pluginDetails() {
        return [
            'name' => 'Twitch Bot',
            'description' => 'Run a Twitch/Discord Bot from your site',
            'author' => 'Joshua Webb',
            'icon' => 'icon-users'
        ];
    }

    public function registerComponents() {
        
    }

    public function registerReportWidgets() {
        return [
            'Tohur\Bot\ReportWidgets\Seactivity' => [
                'label' => 'Stream Elements Activity Feed',
                'context' => 'dashboard',
                'permissions' => [
                    'tohur.bot.*',
                ],
            ],
            'Tohur\Bot\ReportWidgets\Chat' => [
                'label' => 'Twitch Chat',
                'context' => 'dashboard',
                'permissions' => [
                    'tohur.bot.*',
                ],
            ],
            'Tohur\Bot\ReportWidgets\Chatterlist' => [
                'label' => 'Chatter List',
                'context' => 'dashboard',
                'permissions' => [
                    'tohur.bot.*',
                ],
            ],
            'Tohur\Bot\ReportWidgets\Stats' => [
                'label' => 'Stats',
                'context' => 'dashboard',
                'permissions' => [
                    'tohur.bot.*',
                ],
            ],
            'Tohur\Bot\ReportWidgets\Test' => [
                'label' => 'Test',
                'context' => 'dashboard',
                'permissions' => [
                    'tohur.bot.*',
                ],
            ],
        ];
    }

    public function registerSettings() {
        return [
            'settings' => [
                'label' => 'Twitch/Discord Bot',
                'description' => 'Manage Bot Settings.',
                'category' => SettingsManager::CATEGORY_USERS,
                'icon' => 'icon-comments',
                'class' => 'Tohur\Bot\Models\Settings',
                'order' => 600,
                'permissions' => ['rainlab.users.access_settings'],
            ]
        ];
    }

    public function register() {
        $this->registerConsoleCommand('Twitch', 'Tohur\Bot\Console\TwitchBot');
        $this->registerConsoleCommand('Twitchtimers', 'Tohur\Bot\Console\TwitchBotTimers');
        $this->registerConsoleCommand('Twitchusers', 'Tohur\Bot\Console\TwitchBotUsers');
        $this->registerConsoleCommand('Discord', 'Tohur\Bot\Console\DiscordBot');
        $this->registerConsoleCommand('Discordlivepost', 'Tohur\Bot\Console\DiscordBotLivePost');
        $this->registerConsoleCommand('Twitterlivepost', 'Tohur\Bot\Console\TwitterLive');
        $this->registerConsoleCommand('Twittertimedpost', 'Tohur\Bot\Console\TwitterTimed');
    }

    public function boot() {
        $this->fillOwner();
    }

    public function registerSchedule($schedule) {
        $Settings = \Tohur\Bot\Models\Settings::instance()->get('bot', []);
        $schedule->command('bot:twitchchatusers')->cron('*/1 * * * *');
        $schedule->command('bot:discordlivepost')->cron('*/2 * * * *');
        $schedule->command('bot:twitterlive')->cron('*/2 * * * *');
        $schedule->command('bot:twittertimed')->cron('*/' . $Settings['Twitter']['liveperiodicinterval'] . ' * * * *');
        if (\Schema::hasTable('tohur_bot_timer_groups')) {
            $TimerGroups = TimerGroups::all();
            foreach ($TimerGroups as $TimerGroup) {
                $schedule->command('bot:twitchtimers ' . $TimerGroup->id)->cron('*/' . $TimerGroup->timetorun . ' * * * *');
            }
        }
        
        if (\Schema::hasTable('tohur_bot_owners')) {
            $schedule->call(function () {
                $Settings = \Tohur\Bot\Models\Settings::instance()->get('bot', []);
                $twitch = new TwitchAPI();
                if (!strlen($Settings['Twitch']['client_id'])) {
                    
                } else {
                    $client_id = $Settings['Twitch']['client_id'];
                    $client_secret = $Settings['Twitch']['client_secret'];

                    $count = \DB::table('tohur_bot_owners')->count();
                    if ($count == 0) {
                        
                    } else {
                        $Tokens = \DB::table('tohur_bot_owners')->get();
                        foreach ($Tokens as $Token) {
                        $expiresIn = $Token->twitch_expiresIn;
                        $current = Carbon::now();
                        if ($Token->token_updated_at == null) {
                            $time = $Token->token_created_at;
                        } else {
                            $time = $Token->token_updated_at;
                        }
                        $expired = Carbon::parse($time)->addSeconds($expiresIn);

                        if ($current > $expired) {
                           $scopes = 'analytics:read:extensions%20analytics:read:games%20bits:read%20channel:edit:commercial%20channel:read:hype_train%20channel:read:subscriptions%20clips:edit%20user:edit%20user:edit:broadcast%20user:read:broadcast%20user:read:email%20channel_check_subscription%20channel_commercial%20channel_editor%20channel_read%20channel_stream%20channel_subscriptions%20collections_edit%20user_read%20user_subscriptions%20viewing_activity_read%20channel:moderate%20chat:edit%20chat:read%20whispers:read%20whispers:edit';
                            $tokenRequest = json_decode($twitch->helixTokenRequest($twitch->oAuthbaseUrl . "?grant_type=client_credentials&client_id=" . $client_id . "&client_secret=" . $client_secret . "&scope=".$scopes), true);
                            $accessToken = $tokenRequest['access_token'];
                            $tokenExpires = $tokenRequest['expires_in'];
                            \Db::table('tohur_bot_owners')
                                    ->update(['twitch_token' => $accessToken, 'twitch_expiresIn' => $tokenExpires, 'token_updated_at' => now()]);
                        }
                    }
                    }
                }
            })->cron('*/2 * * * *');
        }
    }

    public function registerNavigation() {
        return [
            'bot' => [
                'label' => 'Bot',
                'url' => Backend::url('tohur/bot/corecommands'),
                'icon' => 'icon-comments',
                'permissions' => ['tohur.bot.*'],
                'sideMenu' => [
                    'corecommands' => [
                        'label' => 'Core Commands',
                        'icon' => 'icon-cogs',
                        'url' => Backend::url('tohur/bot/corecommands'),
                        'permissions' => ['tohur.bot.*']
                    ],
                    'customcommands' => [
                        'label' => 'Custom Commands',
                        'icon' => 'icon-cogs',
                        'url' => Backend::url('tohur/bot/customcommands'),
                        'permissions' => ['tohur.bot.*']
                    ],
                    'timergroups' => [
                        'label' => 'Timer Groups',
                        'icon' => 'icon-spinner',
                        'url' => Backend::url('tohur/bot/timergroups'),
                        'permissions' => ['tohur.bot.*']
                    ],
                    'timers' => [
                        'label' => 'Timers',
                        'icon' => 'icon-cogs',
                        'url' => Backend::url('tohur/bot/timers'),
                        'permissions' => ['tohur.bot.*']
                    ],
                    'overlays' => [
                        'label' => 'Overlays',
                        'icon' => 'icon-cogs',
                        'url' => Backend::url('tohur/bot/overlays'),
                        'permissions' => ['tohur.bot.*']
                    ],
                    'users' => [
                        'label' => 'Users',
                        'icon' => 'icon-users',
                        'url' => Backend::url('tohur/bot/users'),
                        'permissions' => ['tohur.bot.*']
                    ]
                ]
            ]
        ];
    }

    public function fillOwner() {
        if (\Schema::hasTable('tohur_bot_owners')) {
            $count = \DB::table('tohur_bot_owners')->count();
            $Settings = \Tohur\Bot\Models\Settings::instance()->get('bot', []);
            if (!strlen($Settings['Twitch']['channel']) && !strlen($Settings['Twitch']['botname']) && !strlen($Settings['Discord']['owner'])) {
                echo 'Please go fill out Discord and Twitch info in bot settings';
            } elseif ($count == 0) {
                $twitch = new TwitchAPI();
                $idCall = $twitch->getUser($Settings['Twitch']['channel']);
                $gameCall = $twitch->getChannelinfo($Settings['Twitch']['channel']);
                Owner::firstOrCreate(['twitch_id' => $idCall[0]['id'], 'twitch' => $Settings['Twitch']['channel'], 'discord' => $Settings['Discord']['owner'], 'game' => $gameCall[0]['game_name']]);
            } else {
                
            }
        }
    }

}
