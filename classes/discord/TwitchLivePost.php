<?php namespace Tohur\Bot\Classes\Discord;

use Tohur\Bot\Classes\FunctionsClass;
use Tohur\Bot\Classes\HelperClass;
use Tohur\Bot\Models\Settings;
use Tohur\SocialConnect\Classes\Apis\TwitchAPI;
use Tohur\Bot\Models\Owner;
use React\EventLoop\Factory;
use CharlotteDunois\Yasmin\Client;

class TwitchLivePost
{
    private $sent = false;

    function __construct($config)
    {
        $this->livePost($config);

    }

    public static function livePost($config)
    {
        $loop = Factory::create();
        $client = new Client(array(), $loop);
        $client->on('error', function ($error) {
            echo $error . PHP_EOL;
        });

        $client->on('ready', function () use ($client) {
            echo 'Logged in as ' . $client->user->tag . ' created on ' . $client->user->createdAt->format('d.m.Y H:i:s') . ' to check if should post live alert'. PHP_EOL;
        });

        $client->once('ready', function () use ($client) {
                    $settings = Settings::instance()->get('bot', []);
                    $twitch = new TwitchAPI();
                    $checkSent = Owner::where('twitch', $settings['Twitch']['channel'])->first();
                    if ($twitch->isChannelLive($settings['Twitch']['channel']) == true && $checkSent->livepostsent == false) {
                        $channel = $client->channels->get($settings['Discord']['livechannel']);
                        $avatarCall = $twitch->getUser($settings['Twitch']['channel']);
                        $botavatarCall = $twitch->getUser($settings['Twitch']['botname']);
                        $game = $twitch->getChannelinfo($settings['Twitch']['channel']);
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
                                ->setTitle($game[0]['game_name'])
                                ->setColor(hexdec('178458'))
                                ->setDescription(':)')
                                ->addField('Game', $game[0]['game_name'])
                                ->addField('Viewers', $viewers, true)
                                ->addField('Total Views', $viewsCall[0]['view_count'], true)
                                ->setThumbnail($avatarCall[0]['profile_image_url'])
                                ->setImage($gameimage)
                                ->setTimestamp()
                                ->setAuthor(ucfirst($settings['Twitch']['channel']), $avatarCall[0]['profile_image_url'], 'https://twitch.tv' . $settings['Twitch']['channel'])
                                ->setFooter(ucfirst($settings['Twitch']['botname']), $botavatarCall[0]['profile_image_url'])
                                ->setURL('https://twitch.tv' . $settings['Twitch']['channel']);

                            // Send the message
                            $channel->send('Hey ' . $roleID . ',' . ucfirst($settings['Twitch']['channel']) . ' Just went live at https://twitch.tv/' . $settings['Twitch']['channel'], array('embed' => $embed))
                                ->done(null, function ($error) {
                                    // We will just echo any errors for this example
                                    echo $error . PHP_EOL;
                                });
                            Owner::where('twitch', $settings['Twitch']['channel'])->update(['livepostsent' => true]);
                            echo 'Live Alert Sent!' . PHP_EOL;
                            exit();
                        }
                    } elseif ($twitch->isChannelLive($settings['Twitch']['channel']) == false && $checkSent->livepostsent == true) {
                        Owner::where('twitch', $settings['Twitch']['channel'])->update(['livepostsent' => false]);
                        echo 'No Live Alert Sent due to being offline' . PHP_EOL;
                        exit();
                    } else {
                        Owner::where('twitch', $settings['Twitch']['channel'])->update(['livepostsent' => false]);
                        echo 'No Live Alert Sent due to being offline' . PHP_EOL;
                        exit();
                    }

        });

        $client->login($config['token'])->done();
        $loop->run();
    }
}