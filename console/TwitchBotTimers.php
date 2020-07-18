<?php

namespace Tohur\Bot\Console;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Tohur\Bot\Models\TimerGroups;
use Tohur\Bot\Models\Timers;
use Tohur\Bot\Classes\Twitch\Timers as BotTimers;
use Tohur\Bot\Classes\Helpers\HelperClass;
use Tohur\Bot\Classes\Helpers\FunctionsClass;

class TwitchBotTimers extends Command {

    /**
     * @var string The console command name.
     */
    protected $name = 'bot:twitchtimers';

    /**
     * @var string The console command description.
     */
    protected $description = 'No description provided yet...';
    private $run = true;

    public function __construct() {
        parent::__construct();
        $this->settings = \Tohur\bot\Models\Settings::instance()->get('bot', []);
        $this->config = array(
            'channel' => '#' . $this->settings['Twitch']['channel'],
            'server' => 'irc.chat.twitch.tv',
            'port' => 6667,
            'nick' => $this->settings['Twitch']['botname'],
            'password' => $this->settings['Twitch']['botpass']
        );
    }

    /**
     * Execute the console command.
     * @return void
     */
    public function handle() {
        $helper = new HelperClass();
        $function = new FunctionsClass();
        $timer = Timers::where('timersgroups_id', $this->argument('id'))->inRandomOrder()->first();
        $response = $timer->response;
        $replace = array(
            '{$user}' => ucfirst($this->settings['Twitch']['channel']),
            '{$userurl}' => 'https://twitch.tv/' . $this->settings['Twitch']['channel'],
            '{$usertitle}' => $function->channelTitle($this->settings['Twitch']['channel']),
            '{$usergame}' => $function->channelGame($this->settings['Twitch']['channel']),
            '{$userviewers}' => $function->viewers($this->settings['Twitch']['channel']),
            '{$uptime}' => $function->uptime($this->settings['Twitch']['channel']),
        );
        $formated = strtr($response, $replace);
        $send = new BotTimers($this->config, $formated);
    }

    /**
     * Get the console command arguments.
     * @return array
     */
    protected function getArguments() {
        return [
            ['id', InputArgument::REQUIRED, 'Timer Group Id.'],
        ];
    }

    /**
     * Get the console command options.
     * @return array
     */
    protected function getOptions() {
        return [];
    }

    public function TwitchBotTimers() {
        $settings = \Tohur\bot\Models\Settings::instance()->get('bot', []);
        $config = array(
            'channel' => '#' . $settings['Twitch']['channel'],
            'server' => 'irc.chat.twitch.tv',
            'port' => 6667,
            'nick' => $settings['Twitch']['botname'],
            'password' => $settings['Twitch']['botpass']
        );
        $helper = new HelperClass();
        $function = new FunctionsClass();
        $timer = Timers::where('timersgroups_id', $this->argument('id'))->inRandomOrder()->first();
        $response = $timer->response;
        $replace = array(
            '{$user}' => ucfirst($this->settings['Twitch']['channel']),
            '{$userurl}' => 'https://twitch.tv/' . $this->settings['Twitch']['channel'],
            '{$usertitle}' => $function->channelTitle($this->settings['Twitch']['channel']),
            '{$usergame}' => $function->channelGame($this->settings['Twitch']['channel']),
        );
        $formated = strtr($text, $replace);
        $send = new BotTimers($config, $response);
    }

}