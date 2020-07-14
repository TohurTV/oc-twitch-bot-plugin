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
    }

    public function boot() {
        $this->fillOwner();
    }

    public function registerSchedule($schedule) {
        $Settings = \Tohur\Bot\Models\Settings::instance()->get('bot', []);
        $schedule->command('bot:twitchchatusers')->cron('*/1 * * * *');
        $schedule->command('bot:discordlivepost')->cron('*/2 * * * *');
        $schedule->command('bot:twitterlive')->cron('*/2 * * * *');

        if (!strlen($Settings['Twitter']['liveperiodicinterval'])) {
            $tweetTime = '120';
        } else {
           $tweetTime = $Settings['Twitter']['liveperiodicinterval']; 
        }
        $schedule->command('bot:twittertimed')->cron('*/'.$tweetTime.' * * * *');
    }

    public function registerNavigation() {
        return [
            'bot' => [
                'label' => 'bot',
                'url' => Backend::url('tohur/bot/commands'),
                'icon' => 'icon-comments',
                'permissions' => ['tohur.bot.*'],
                'sideMenu' => [
                    'commands' => [
                        'label' => 'Commands',
                        'icon' => 'icon-cogs',
                        'url' => Backend::url('tohur/bot/commands'),
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
                Owner::create(['twitch_id' => $idCall[0]['id'], 'twitch' => $Settings['Twitch']['channel'], 'discord' => $Settings['Discord']['owner'], 'game' => $gameCall[0]['game_name']]);
            } else {
                
            }
        }
    }

}
