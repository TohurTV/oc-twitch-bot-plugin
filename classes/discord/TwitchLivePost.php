<?php

namespace Tohur\Bot\Classes\Discord;

use Tohur\Bot\Classes\FunctionsClass;
use Tohur\Bot\Classes\HelperClass;
use Tohur\Bot\Models\Settings;
use Tohur\SocialConnect\Classes\Apis\TwitchAPI;
use Tohur\Bot\Models\Owner;
use React\EventLoop\Factory;
use CharlotteDunois\Yasmin\Client;

class TwitchLivePost {

    private $sent = false;

    function __construct($config) {
        $this->livePost($config);
    }

    public static function livePost($config) {
        $loop = Factory::create();
        $discord = new Client(array(), $loop);
        $discord->once('ready', function() use ($discord) {
            $settings = Settings::instance()->get('bot', []);
            $twitch = new TwitchAPI();
            $channel = $discord->channels->get($settings['Discord']['livechannel']);
            $avatarCall = $twitch->getUser($settings['Twitch']['channel']);
            $botavatarCall = $twitch->getUser($settings['Twitch']['botname']);
            $game = $twitch->getChannelinfo($settings['Twitch']['channel']);
            $title = $twitch->getChannelinfo($settings['Twitch']['channel']);
            $gameimage1 = "https://static-cdn.jtvnw.net/ttv-boxart/";
            $gameimage2 = str_replace(' ', '%20', $game[0]['game_name']);
            $gameimage3 = "-600x800.jpg";
            $gameimage = $gameimage1 . $gameimage2 . $gameimage3;
            $viewerCall = $twitch->getStream($settings['Twitch']['channel']);
            if ($viewerCall == null) {
                $viewers = $settings['Twitch']['channel'] . ' is offline';
            } else {
                $viewers = $viewerCall[0]['viewer_count'];
            }
            $viewsCall = $twitch->getUser($settings['Twitch']['channel']);

            if ($settings['Discord']['roleid'] == '') {
                $roleID = '';
            } else if ($settings['Discord']['roleid'] == 'here') {
                $roleID = '@here';
            } else if ($settings['Discord']['roleid'] == 'everyone') {
                $roleID = '@everyone';
            } else {
                $roleID = "<@&" . $settings['Discord']['roleid'] . ">";
            }

            // Making sure the channel exists
            if ($channel) {
                $embed = new \CharlotteDunois\Yasmin\Models\MessageEmbed();

                // Build the embed
                $embed
                        ->setTitle($title[0]['title'])
                        ->setColor(hexdec('178458'))
                        ->addField('Game', $game[0]['game_name'])
                        ->addField('Viewers', $viewers, true)
                        ->addField('Total Views', $viewsCall[0]['view_count'], true)
                        ->setThumbnail($avatarCall[0]['profile_image_url'])
                        ->setImage($gameimage)
                        ->setTimestamp()
                        ->setAuthor(ucfirst($settings['Twitch']['channel']), $avatarCall[0]['profile_image_url'], 'https://twitch.tv' . $settings['Twitch']['channel'])
                        ->setFooter(ucfirst($settings['Twitch']['botname']), $botavatarCall[0]['profile_image_url'])
                        ->setURL('https://twitch.tv/' . $settings['Twitch']['channel']);
                // Send the message
                // We do not need another promise here, so
                // we call done, because we want to consume the promise
                $channel->send('Hey ' . $roleID . ',' . ucfirst($settings['Twitch']['channel']) . ' Just went live at https://twitch.tv/' . $settings['Twitch']['channel'], array('embed' => $embed))
                        ->done(null, function ($error) {
                            // We will just echo any errors for this example
                            echo $error . PHP_EOL;
                        });
            }
        });

        $discord->login($config['token']);

        $timer = $loop->addPeriodicTimer(0.1, function () {
            echo 'sending live post!' . PHP_EOL;
        });

        $loop->addTimer(2.0, function () use ($loop, $timer) {
            $loop->cancelTimer($timer);
            echo 'Done' . PHP_EOL;
            $loop->stop();
        });
        $loop->run();
    }

}
