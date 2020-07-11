<?php namespace Tohur\Bot;

use App;
use Auth;
use Backend\Widgets\Form;
use Event;
use Backend;
use System\Classes\PluginBase;
use System\Classes\SettingsManager;
use Illuminate\Foundation\AliasLoader;

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
                'icon' => 'icon-users',
                'class' => 'Tohur\Bot\Models\Settings',
                'order' => 600,
                'permissions' => ['rainlab.users.access_settings'],
            ]
        ];
    }

    public function register()
    {
        $this->registerConsoleCommand('Twitch', 'Tohur\Bot\Console\TwitchBot');
        $this->registerConsoleCommand('Discord', 'Tohur\Bot\Console\DiscordBot');
    }
    public function boot()
    {

    }
    public function registerNavigation()
    {
        return [
            'bot' => [
                'label'       => 'bot',
                'url'         => Backend::url('tohur/bot/commands'),
                'icon'        => 'icon-comments',
                'permissions' => ['tohur.bot.*'],

                'sideMenu'    => [
                    'commands' => [
                        'label' => 'Commands',
                        'icon'        => 'icon-cogs',
                        'url'         => Backend::url('tohur/bot/commands'),
                        'permissions' => ['tohur.bot.*']

                    ],
                    'timergroups' => [
                        'label' => 'Timer Groups',
                        'icon'        => 'icon-spinner',
                        'url'         => Backend::url('tohur/bot/timergroups'),
                        'permissions' => ['tohur.bot.*']

                    ],
                    'timers' => [
                        'label' => 'Timers',
                        'icon'        => 'icon-cogs',
                        'url'         => Backend::url('tohur/bot/timers'),
                        'permissions' => ['tohur.bot.*']

                    ]
                ]
            ]
        ];
    }
}
