<?php namespace Tohur\Bot\Console;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Tohur\Bot\Classes\Discord\TwitchLivePost;
use Tohur\SocialConnect\Classes\Apis\TwitchAPI;

class DiscordBotLivePost extends Command
{
    /**
     * @var string The console command name.
     */
    protected $name = 'bot:discordlivepost';

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
            'token' => $this->settings['Discord']['token']
        );

    }

    /**
     * Execute the console command.
     * @return void
     */
    public function handle()
    {
        $twitch = new TwitchAPI();
        if ($twitch->isChannelLive($this->settings['Twitch']['channel']) == true) {
            return $this->DiscordBotLivePost();
        } else {
            $this->output->writeln($this->settings['Twitch']['channel'].' is not online');
        }

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

    public function DiscordBotLivePost()
    {
        $Discordbot = new TwitchLivePost($this->config);
    }
}