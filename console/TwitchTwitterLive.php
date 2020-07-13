<?php namespace Tohur\Bot\Console;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
Use Tohur\SocialConnect\Classes\Apis\TwitterClient;
use Tohur\SocialConnect\Classes\Apis\TwitchAPI;

class TwitchTwitterLive extends Command
{
    /**
     * @var string The console command name.
     */
    protected $name = 'bot:twitchtwitterlive';

    /**
     * @var string The console command description.
     */
    protected $description = 'No description provided yet...';

    private $run = true;

    public function __construct()
    {
        parent::__construct();
        $this->settings = \Tohur\Bot\Models\Settings::instance()->get('bot', []);

    }

    /**
     * Execute the console command.
     * @return void
     */
    public function handle()
    {
        $twitch = new TwitchAPI();
        if ($twitch->isChannelLive($this->settings['Twitch']['channel']) == true) {
            $twitter = new TwitterClient();
            $apiCall = $twitter->posttweet($name);

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

    public function TwitchTwitterLivePost()
    {
        $Tweet = new TwitterClient($this->config);
    }
}