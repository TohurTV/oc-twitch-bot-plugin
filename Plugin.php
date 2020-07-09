<?php namespace Tohur\Bot;

use App;
use Auth;
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
            'description' => 'Run a Twitch/Discord Bot from you site',
            'author' => 'Joshua Webb',
            'icon' => 'icon-users'
        ];
    }

    public function registerComponents()
    {
    }

    public function registerSettings()
    {
    }

    public function register()
    {
        $this->registerConsoleCommand('Bot', 'Tohur\Bot\Console\Bot');
    }

    public function registerNavigation()
    {
        return [
            'commands' => [
                'label' => 'Bot',
                'url' => Backend::url('tohur/bot/commands'),
                'icon' => 'icon-pencil',
                'permissions' => ['tohur.bot.*'],
                'order' => 500,
                // Set counter to false to prevent the default behaviour of the main menu counter being a sum of
                // its side menu counters
                'counter' => false,
                'counterLabel' => 'Label describing a dynamic menu counter',
            ]
        ];
    }
}
