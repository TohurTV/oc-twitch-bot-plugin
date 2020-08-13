<?php

namespace Tohur\Bot\Console;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Tohur\Bot\Classes\Discord\TwitchLivePost;
use Tohur\Bot\Models\Owner;
use Tohur\SocialConnect\Classes\Apis\TwitchAPI;

class DiscordBotLivePostTest extends Command {

    /**
     * @var string The console command name.
     */
    protected $name = 'bot:discordliveposttest';

    /**
     * @var string The console command description.
     */
    protected $description = 'No description provided yet...';
    private $run = true;

    public function __construct() {
        parent::__construct();
        $this->settings = \Tohur\bot\Models\Settings::instance()->get('bot', []);
        $this->config = array(
            'token' => $this->settings['Discord']['token']
        );
    }

    /**
     * Execute the console command.
     * @return void
     */
    public function handle() {

            $this->DiscordBotLivePost();

    }

    /**
     * Get the console command arguments.
     * @return array
     */
    protected function getArguments() {
        return [];
    }

    /**
     * Get the console command options.
     * @return array
     */
    protected function getOptions() {
        return [];
    }

    public function DiscordBotLivePost() {
        $Discordbot = new TwitchLivePost($this->config);
    }

}
