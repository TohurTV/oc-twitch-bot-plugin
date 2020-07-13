<?php namespace Tohur\Bot;

use App;
use Auth;
use Backend\Widgets\Form;
use Event;
use Backend;
use System\Classes\PluginBase;
use System\Classes\SettingsManager;
use Illuminate\Foundation\AliasLoader;
use Tohur\Bot\Models\Owner;
use RestCord\DiscordClient;
use Tohur\SocialConnect\Classes\Apis\TwitchAPI;

class Plugin extends PluginBase
{
    // Make this plugin run on updates page
    public $elevated = true;
    public $require = ['Tohur.SocialConnect'];

    /**
     * Returns information about this plugin.
     *
     * @return array
     */
    public function pluginDetails()
    {
        return [
            'name' => 'Twitch Bot',
            'description' => 'Run a Twitch/Discord Bot from your site',
            'author' => 'Joshua Webb',
            'icon' => 'icon-users'
        ];
    }

    public function registerComponents()
    {
    }

    public function registerSettings()
    {
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

    public function register()
    {
        $this->registerConsoleCommand('Twitch', 'Tohur\Bot\Console\TwitchBot');
        $this->registerConsoleCommand('Twitchtimers', 'Tohur\Bot\Console\TwitchBotTimers');
        $this->registerConsoleCommand('Discord', 'Tohur\Bot\Console\DiscordBot');
        $this->registerConsoleCommand('Discordlivepost', 'Tohur\Bot\Console\DiscordBotLivePost');
//        $this->fillOwner();
    }

    public function boot()
    {
        $this->fillOwner();
    }

    public function registerSchedule($schedule)
    {
        // Check if should Post Live alert in Discord
        $schedule->command('bot:discordlivepost')->cron('*/2 * * * *');
    }

    public function registerNavigation()
    {
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

                    ]
                ]
            ]
        ];
    }

    public function fillOwner()
    {
        $count = \DB::table('tohur_bot_owners')->count();
        $Settings = \Tohur\Bot\Models\Settings::instance()->get('bot', []);
        if (!strlen($Settings['Twitch']['channel']) && !strlen($Settings['Twitch']['botname'] ) && !strlen($Settings['Discord']['owner'])) {
            echo 'Please go fill out Discord and Twitch info in bot settings';
        } elseif ($count == 0){
            $twitch = new TwitchAPI();
            $idCall = $twitch->getUser($Settings['Twitch']['channel']);
            $gameCall = $twitch->getChannelinfo($Settings['Twitch']['channel']);
            Owner::create(['twitch_id' => $idCall[0]['id'], 'twitch' => $Settings['Twitch']['channel'], 'discord' => $Settings['Discord']['owner'], 'game' => $gameCall[0]['game_name']]);
        } else {

        }

    }
}
