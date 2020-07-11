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
        $this->config = array(
            'ssl' => false,
            'channels' => array('#tohur'),
            'username' => 'tohur_bot',
            'realname' => 'tohur_bot',
            'nick' => 'tohur_bot',
            'master' => 'tohur',
            "unflood" => 500,
            "admins" => array('tohur'),
            "debug" => true,
            "log" => public_path() . '/tohur/bot/bot.log',
            'password' => ''
        );

    }

    /**
     * Execute the console command.
     * @return void
     */
    public function handle()
    {
            return $this->TwitchBot();
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