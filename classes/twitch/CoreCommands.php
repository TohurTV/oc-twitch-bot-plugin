<?php

namespace Tohur\Bot\Classes\Twitch;

use Tohur\Bot\Classes\Helpers\FunctionsClass;
use Tohur\Bot\Models\CoreCommands as CommandsDB;
use Tohur\Bot\Models\Users;
use Tohur\Bot\Classes\Helpers\HelperClass;
use Tohur\Twitchirc\AbstractPlugin as BasePlugin;
use Tohur\Twitchirc\IRC\Response;

class CoreCommands extends BasePlugin {

    /**
     * Does the 'heavy lifting' of initializing the plugin's behavior
     */
    public function init() {
        $this->bot->onChannel('/^!echo (.*)$/', function($event) {
            $request = $event->getRequest();
            $matches = $event->getMatches();
            $event->addResponse(Response::msg($request->getSource(), trim($matches[0])));
        });

        // Account Age Command
        $this->bot->onChannel('/^!age(.*)$/', function($event) {
            $helper = new HelperClass();
            $function = new FunctionsClass();
            $request = $event->getRequest();
            $matches = $event->getMatches();

            $command = CommandsDB::where('command', 'age')->first();
            if (empty($matches[0])) {
                $targetUser = $request->getSendingUser();
            } else {
                $targetUser = trim($matches[0]);
            }
            $replace = array(
                '{$age}' => $function->accountage($targetUser),
                '{$targetuser}' => $targetUser,
            );
            $formated = strtr($command->response, $replace);
            $event->addResponse(Response::msg($request->getSource(), "{$formated}"));
        });

        // Follow Age Command
        $this->bot->onChannel('/^!followage(.*)$/', function($event) {
            $helper = new HelperClass();
            $function = new FunctionsClass();
            $request = $event->getRequest();
            $matches = $event->getMatches();

            $command = CommandsDB::where('command', 'followage')->first();
            if (empty($matches[0])) {
                $targetUser = $request->getSendingUser();
            } else {
                $targetUser = trim($matches[0]);
            }
            $replace = array(
                '{$followage}' => $function->followage($targetUser),
                '{$targetuser}' => $targetUser,
            );
            $formated = strtr($command->response, $replace);
            $event->addResponse(Response::msg($request->getSource(), "{$formated}"));
        });

        // Last seen Command
        $this->bot->onChannel('/^!lastseen(.*)$/', function($event) {
            $helper = new HelperClass();
            $function = new FunctionsClass();
            $request = $event->getRequest();
            $matches = $event->getMatches();

            $command = CommandsDB::where('command', 'lastseen')->first();
            if (empty($matches[0])) {
                $targetUser = $request->getSendingUser();
            } else {
                $targetUser = trim($matches[0]);
            }
            $replace = array(
                '{$lastseen}' => $function->lastseen($helper->remove_hashtags($request->getSource()), $targetUser),
                '{$targetuser}' => $targetUser,
            );
            $formated = strtr($command->response, $replace);
            $event->addResponse(Response::msg($request->getSource(), "{$formated}"));
        });

        // Uptime Command
        $this->bot->onChannel('/^!uptime(.*)$/', function($event) {
            $helper = new HelperClass();
            $function = new FunctionsClass();
            $request = $event->getRequest();

            $command = CommandsDB::where('command', 'uptime')->first();
            $replace = array(
                '{$user}' => $helper->remove_hashtags($request->getSource()),
                '{$uptime}' => $function->uptime($helper->remove_hashtags($request->getSource())),
            );
            $formated = strtr($command->response, $replace);
            $event->addResponse(Response::msg($request->getSource(), "{$formated}"));
        });

        // Follower count Command
        $this->bot->onChannel('/^!followers(.*)$/', function($event) {
            $helper = new HelperClass();
            $function = new FunctionsClass();
            $request = $event->getRequest();

            $command = CommandsDB::where('command', 'followers')->first();
            $replace = array(
                '{$user}' => $helper->remove_hashtags($request->getSource()),
                '{$followers}' => $function->followcount($helper->remove_hashtags($request->getSource())),
            );
            $formated = strtr($command->response, $replace);
            $event->addResponse(Response::msg($request->getSource(), "{$formated}"));
        });

        // Sub count Command
        $this->bot->onChannel('/^!subs(.*)$/', function($event) {
            $helper = new HelperClass();
            $function = new FunctionsClass();
            $request = $event->getRequest();

            $command = CommandsDB::where('command', 'subs')->first();
            $replace = array(
                '{$user}' => $helper->remove_hashtags($request->getSource()),
                '{$subs}' => $function->subcount($helper->remove_hashtags($request->getSource())),
            );
            $formated = strtr($command->response, $replace);
            $event->addResponse(Response::msg($request->getSource(), "{$formated}"));
        });
    }

    /**
     * Returns the Plugin's name
     */
    public function getName() {
        return 'CoreCommands';
    }

}
