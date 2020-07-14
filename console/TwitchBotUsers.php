<?php namespace Tohur\Bot\Console;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Tohur\Bot\Classes\TwitchBotClass;
use Tohur\Bot\Models\Users;
use Tohur\SocialConnect\Classes\Apis\TwitchAPI;

class TwitchBotUsers extends Command
{
    /**
     * @var string The console command name.
     */
    protected $name = 'bot:twitchchatusers';

    /**
     * @var string The console command description.
     */
    protected $description = 'No description provided yet...';


    public function __construct()
    {
        parent::__construct();

    }

    /**
     * Execute the console command.
     * @return void
     */
    public function handle()
    {
        $twitch = new TwitchAPI();
        $Settings = \Tohur\Bot\Models\Settings::instance()->get('bot', []);
        $viewerscall= $twitch->getChatusers($Settings['Twitch']['channel']);

        foreach($viewerscall->chatters->broadcaster as $obj) {
            $broadcaster = $obj;
            $userid = $twitch->getUser($broadcaster);
            $channelID = $userid[0]['id'];
            $broadcasteruser = Users::firstOrCreate(['twitch_id' => $channelID, 'twitch' => $broadcaster]);

        }
        foreach($viewerscall->chatters->vips as $obj) {
            $vip = $obj;
            $userid = $twitch->getUser($vip);
            $channelID = $userid[0]['id'];
            $vipsuser = Users::firstOrCreate(['twitch_id' => $channelID, 'twitch' => $vip]);

        }
        foreach($viewerscall->chatters->moderators as $obj) {
            $moderator = $obj;
            $userid = $twitch->getUser($moderator);
            $channelID = $userid[0]['id'];
            $moderatorsuser = Users::firstOrCreate(['twitch_id' => $channelID, 'twitch' => $moderator]);

        }
        foreach($viewerscall->chatters->viewers as $obj) {
            $viewer = $obj;
            $userid = $twitch->getUser($viewer);
            $channelID = $userid[0]['id'];
            $viewersuser = Users::firstOrCreate(['twitch_id' => $channelID, 'twitch' => $viewer]);

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

    public function TwitchBot()
    {
        $Twitchbot = new TwitchBotClass($this->config);
    }
}