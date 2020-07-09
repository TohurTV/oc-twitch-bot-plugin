<?php namespace Tohur\Bot;

use System\Classes\PluginBase;

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
    public function pluginDetails() {
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
}
