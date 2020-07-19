<?php namespace Tohur\Bot\Console;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Tohur\Bot\Classes\TwitchBotClass;

class TwitchBot extends Command
{
    /**
     * @var string The console command name.
     */
    protected $name = 'bot:twitch';

    /**
     * @var string The console command description.
     */
    protected $description = 'No description provided yet...';

    private $run = true;

    public function __construct()
    {
        parent::__construct();
        $this->settings = \Tohur\bot\Models\Settings::instance()->get('bot', []);
        $this->config = array(
            'ssl' => false,
            'channels' => array('#'.$this->settings['Twitch']['channel']),
            'username' => $this->settings['Twitch']['botname'],
            'realname' => $this->settings['Twitch']['botname'],
            'nick' => $this->settings['Twitch']['botname'],
            'master' => $this->settings['Twitch']['channel'],
            "unflood" => 500,
            "admins" => array($this->settings['Twitch']['channel']),
            "debug" => true,
            "log" => plugins_path() . '/tohur/bot/bot.log',
            'password' => $this->settings['Twitch']['botpass']
        );

    }

    /**
     * Execute the console command.
     * @return void
     */
    public function handle()
    {
           $Twitchbot = new TwitchBotClass($this->config);
    }

    /**
     * Get the console command arguments.
     * @return array
     */
    protected function getArguments()
    {
        return [];
    }

    /**
     * Get the console command options.
     * @return array
     */
    protected function getOptions()
    {
        return [];
    }

    public function TwitchBot()
    {
        $Twitchbot = new TwitchBotClass($this->config);
    }
}