<?php

namespace Tohur\Bot\Classes;

use Tohur\Bot\Classes\FunctionsClass;
use Tohur\Bot\Classes\HelperClass;
use Tohur\Bot\Classes\Discord\TwitchLivePost;

use RestCord\DiscordClient;

class DiscordBotClass
{

    function __construct($config)
    {
        $this->run($config);
    }

    public function run($config)
    {
        $loop = \React\EventLoop\Factory::create();
        $client = new \CharlotteDunois\Yasmin\Client(array(), $loop);
        $client->on('error', function ($error) {
            echo $error . PHP_EOL;
        });
        $client->once('ready', function () use ($client) {
            echo 'Logged in as ' . $client->user->tag . ' created on ' . $client->user->createdAt->format('d.m.Y H:i:s') . PHP_EOL;
        });

        $client->on('message', function ($message) {
            echo 'Received Message from ' . $message->author->tag . ' in ' . ($message->channel instanceof \CharlotteDunois\Yasmin\Interfaces\DMChannelInterface ? 'DM' : 'channel #' . $message->channel->name) . ' with ' . $message->attachments->count() . ' attachment(s) and ' . \count($message->embeds) . ' embed(s)' . PHP_EOL;
        });

        $client->login($config['token'])->done();

        $loop->run();
    }
}
