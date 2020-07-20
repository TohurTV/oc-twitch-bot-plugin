<?php

namespace Tohur\Bot\Classes;

use Tohur\Bot\Classes\FunctionsClass;
use Tohur\Bot\Classes\HelperClass;
use Tohur\Bot\Classes\Discord\TwitchLivePost;
use charlottedunois\yasmin;

class DiscordBotClass {

    function __construct($config) {
        $this->run($config);
    }

    public function run($config) {
        $loop = \React\EventLoop\Factory::create();
        $discord = new \CharlotteDunois\Yasmin\Client(array(), $loop);

        $discord->on('error', function ($error) {
            echo $error . PHP_EOL;
        });
        $discord->once('ready', function () use ($discord) {
            $discord->user->setPresence(//Discord status
                    array(
                        'since' => null, //unix time (in milliseconds) of when the client went idle, or null if the client is not idle
                        'game' => array(
                            'name' => "Under construction!",
                            'type' => 3, //0, 1, 2, 3, 4 | Game/Playing, Streaming, Listening, Watching, Custom Status
                            'url' => null //stream url, is validated when type is 1, only Youtube and Twitch allowed
                        /*
                          Bots are only able to send name, type, and optionally url.
                          As bots cannot send states or emojis, they can't make effective use of custom statuses.
                          The header for a "Custom Status" may show up on their profile, but there is no actual custom status, because those fields are ignored.
                         */
                        ),
                        'status' => 'online', //online, dnd, idle, invisible, offline
                        'afk' => false
                    )
            );
            echo 'Logged in as ' . $discord->user->tag . ' created on ' . $discord->user->createdAt->format('d.m.Y H:i:s') . PHP_EOL;
        });

        $discord->on('message', function ($message) {
            echo 'Received Message from ' . $message->author->tag . ' in ' . ($message->channel instanceof \CharlotteDunois\Yasmin\Interfaces\DMChannelInterface ? 'DM' : 'channel #' . $message->channel->name) . ' with ' . $message->attachments->count() . ' attachment(s) and ' . \count($message->embeds) . ' embed(s)' . PHP_EOL;
        });

        $discord->login($config['token'])->done();

        $loop->run();
    }

}
