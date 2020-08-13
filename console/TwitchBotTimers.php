<?php

namespace Tohur\Bot\Console;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Tohur\Bot\Models\TimerGroups;
use Tohur\Bot\Models\Timers;
use Tohur\Bot\Models\CustomCommands;
use Tohur\Bot\Classes\Twitch\SendToChannel as BotTimers;
use Tohur\Bot\Classes\Helpers\HelperClass;
use Tohur\Bot\Classes\Helpers\FunctionsClass;
use Tohur\SocialConnect\Classes\Apis\TwitchAPI;

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
        $twitch = new TwitchAPI();
        if ($twitch->isChannelLive($this->settings['Twitch']['channel']) == true) {
            $helper = new HelperClass();
            $function = new FunctionsClass();
            $timer = Timers::where('timersgroups_id', $this->argument('id'))->inRandomOrder()->first();
            if ($timer->command == true) {
                $command = CustomCommands::where('command', $timer->response)->first();

                $response = $command->response;
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
            } else {
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
        } else {
            $this->output->writeln($this->settings['Twitch']['channel'] . ' is not online');
        }
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

}
