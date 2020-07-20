<?php

namespace Tohur\Bot\Console;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
Use Tohur\SocialConnect\Classes\Apis\TwitterClient;
use Tohur\SocialConnect\Classes\Apis\TwitchAPI;
use Tohur\Bot\Classes\Helpers\FunctionsClass;
use Tohur\Bot\Classes\Helpers\HelperClass;
use Tohur\Bot\Models\Owner;

class TwitterLive extends Command {

    /**
     * @var string The console command name.
     */
    protected $name = 'bot:twitterlive';

    /**
     * @var string The console command description.
     */
    protected $description = 'No description provided yet...';
    private $run = true;

    public function __construct() {
        parent::__construct();
        $this->settings = \Tohur\Bot\Models\Settings::instance()->get('bot', []);
    }

    /**
     * Execute the console command.
     * @return void
     */
    public function handle() {
        $twitch = new TwitchAPI();
        $Tweet = new TwitterClient();
        $helper = new HelperClass();
        $function = new FunctionsClass();
        if (!strlen($this->settings['Twitch']['channel'])) {
            echo 'Please Setup Twitch in Bot settings';
        } else {
            if (\Schema::hasTable('tohur_bot_owners')) {
                $checkSent = Owner::where('twitch', $this->settings['Twitch']['channel'])->first();
                if ($twitch->isChannelLive($this->settings['Twitch']['channel']) == true && $checkSent->tweetsent == false) {
                    $text = $this->settings['Twitter']['livetweet'];
                    $replace = array(
                        '{$user}' => ucfirst($this->settings['Twitch']['channel']),
                        '{$userurl}' => 'https://twitch.tv/' . $this->settings['Twitch']['channel'],
                        '{$usertitle}' => $function->channelTitle($this->settings['Twitch']['channel']),
                        '{$usergame}' => $function->channelGame($this->settings['Twitch']['channel']),
                    );
                    $formated = strtr($text, $replace);
                    $apiCall = $Tweet->posttweet($formated);
                    Owner::where('twitch', $this->settings['Twitch']['channel'])->update(['tweetsent' => true]);
                } elseif ($twitch->isChannelLive($this->settings['Twitch']['channel']) == true && $checkSent->livepostsent == true) {
                    echo 'Live Tweet already sent this session' . PHP_EOL;
                } elseif ($twitch->isChannelLive($this->settings['Twitch']['channel']) == false && $checkSent->livepostsent == true) {
                    Owner::where('twitch', $this->settings['Twitch']['channel'])->update(['tweetsent' => false]);
                    echo 'No Live Tweet Sent due to being offline' . PHP_EOL;
                } else {
                    Owner::where('twitch', $this->settings['Twitch']['channel'])->update(['tweetsent' => false]);
                    echo 'No Live Tweet Sent due to being offline' . PHP_EOL;
                }
            }
        }
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

}
