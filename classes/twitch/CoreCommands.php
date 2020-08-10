<?php

namespace Tohur\Bot\Classes\Twitch;

use Tohur\Bot\Classes\Helpers\FunctionsClass;
use Tohur\Bot\Models\CoreCommands as CommandsDB;
use Tohur\Bot\Models\Users;
use Tohur\Bot\Models\Roles;
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
                $targetUser = $helper->remove_atsign(trim($matches[0]));
            }
            $replace = array(
                '{$age}' => $function->accountage($targetUser),
                '{$targetuser}' => $targetUser,
            );
            $formated = strtr($command->response, $replace);

            $user = Users::where('channel', $helper->remove_hashtags($request->getSource()))
                    ->where('twitch_id', $function->userid($helper->remove_hashtags($request->getSendingUser())))
                    ->where('twitch', $helper->remove_hashtags($request->getSendingUser()))
                    ->first();

            $broadcasterrole = Roles::where('code', 'broadcaster')->first();
            $requiredRole = Roles::where('id', $command->roles_id)->first();
            if ($user->inRole($broadcasterrole)) {
                $event->addResponse(Response::msg($request->getSource(), "{$formated}"));
            } elseif ($user->inRole($requiredRole)) {
                $event->addResponse(Response::msg($request->getSource(), "{$formated}"));
            } else {
                $event->addResponse(Response::msg($request->getSource(), "You Do not have the proper permission to use this command"));
            }
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
                $targetUser = $helper->remove_atsign(trim($matches[0]));
            }
            $replace = array(
                '{$followage}' => $function->followage($targetUser),
                '{$targetuser}' => $targetUser,
            );
            $formated = strtr($command->response, $replace);

            $user = Users::where('channel', $helper->remove_hashtags($request->getSource()))
                    ->where('twitch_id', $function->userid($helper->remove_hashtags($request->getSendingUser())))
                    ->where('twitch', $helper->remove_hashtags($request->getSendingUser()))
                    ->first();

            $broadcasterrole = Roles::where('code', 'broadcaster')->first();
            $requiredRole = Roles::where('id', $command->roles_id)->first();
            if ($user->inRole($broadcasterrole)) {
                $event->addResponse(Response::msg($request->getSource(), "{$formated}"));
            } elseif ($user->inRole($requiredRole)) {
                $event->addResponse(Response::msg($request->getSource(), "{$formated}"));
            } else {
                $event->addResponse(Response::msg($request->getSource(), "You Do not have the proper permission to use this command"));
            }
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
                $targetUser = $helper->remove_atsign(trim($matches[0]));
            }
            $replace = array(
                '{$lastseen}' => $function->lastseen($helper->remove_hashtags($request->getSource()), $targetUser),
                '{$targetuser}' => $targetUser,
            );
            $formated = strtr($command->response, $replace);

            $user = Users::where('channel', $helper->remove_hashtags($request->getSource()))
                    ->where('twitch_id', $function->userid($helper->remove_hashtags($request->getSendingUser())))
                    ->where('twitch', $helper->remove_hashtags($request->getSendingUser()))
                    ->first();

            $broadcasterrole = Roles::where('code', 'broadcaster')->first();
            $requiredRole = Roles::where('id', $command->roles_id)->first();
            if ($user->inRole($broadcasterrole)) {
                $event->addResponse(Response::msg($request->getSource(), "{$formated}"));
            } elseif ($user->inRole($requiredRole)) {
                $event->addResponse(Response::msg($request->getSource(), "{$formated}"));
            } else {
                $event->addResponse(Response::msg($request->getSource(), "You Do not have the proper permission to use this command"));
            }
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

            $user = Users::where('channel', $helper->remove_hashtags($request->getSource()))
                    ->where('twitch_id', $function->userid($helper->remove_hashtags($request->getSendingUser())))
                    ->where('twitch', $helper->remove_hashtags($request->getSendingUser()))
                    ->first();

            $broadcasterrole = Roles::where('code', 'broadcaster')->first();
            $requiredRole = Roles::where('id', $command->roles_id)->first();
            if ($user->inRole($broadcasterrole)) {
                $event->addResponse(Response::msg($request->getSource(), "{$formated}"));
            } elseif ($user->inRole($requiredRole)) {
                $event->addResponse(Response::msg($request->getSource(), "{$formated}"));
            } else {
                $event->addResponse(Response::msg($request->getSource(), "You Do not have the proper permission to use this command"));
            }
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

            $user = Users::where('channel', $helper->remove_hashtags($request->getSource()))
                    ->where('twitch_id', $function->userid($helper->remove_hashtags($request->getSendingUser())))
                    ->where('twitch', $helper->remove_hashtags($request->getSendingUser()))
                    ->first();

            $broadcasterrole = Roles::where('code', 'broadcaster')->first();
            $requiredRole = Roles::where('id', $command->roles_id)->first();
            if ($user->inRole($broadcasterrole)) {
                $event->addResponse(Response::msg($request->getSource(), "{$formated}"));
            } elseif ($user->inRole($requiredRole)) {
                $event->addResponse(Response::msg($request->getSource(), "{$formated}"));
            } else {
                $event->addResponse(Response::msg($request->getSource(), "You Do not have the proper permission to use this command"));
            }
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

            $user = Users::where('channel', $helper->remove_hashtags($request->getSource()))
                    ->where('twitch_id', $function->userid($helper->remove_hashtags($request->getSendingUser())))
                    ->where('twitch', $helper->remove_hashtags($request->getSendingUser()))
                    ->first();

            $broadcasterrole = Roles::where('code', 'broadcaster')->first();
            $requiredRole = Roles::where('id', $command->roles_id)->first();
            if ($user->inRole($broadcasterrole)) {
                $event->addResponse(Response::msg($request->getSource(), "{$formated}"));
            } elseif ($user->inRole($requiredRole)) {
                $event->addResponse(Response::msg($request->getSource(), "{$formated}"));
            } else {
                $event->addResponse(Response::msg($request->getSource(), "You Do not have the proper permission to use this command"));
            }
        });

        // Watch Time Command
        $this->bot->onChannel('/^!watchtime(.*)$/', function($event) {
            $helper = new HelperClass();
            $function = new FunctionsClass();
            $request = $event->getRequest();
            $matches = $event->getMatches();

            $command = CommandsDB::where('command', 'watchtime')->first();

            if (empty($matches[0])) {
                $targetUser = $request->getSendingUser();
            } else {
                $targetUser = $helper->remove_atsign(trim($matches[0]));
            }

            $replace = array(
                '{$user}' => $helper->remove_hashtags($request->getSource()),
                '{$targetuser}' => $targetUser,
                '{$watchtime}' => $function->watchtime($helper->remove_hashtags($request->getSource()), $targetUser),
            );
            $formated = strtr($command->response, $replace);

            $user = Users::where('channel', $helper->remove_hashtags($request->getSource()))
                    ->where('twitch_id', $function->userid($helper->remove_hashtags($request->getSendingUser())))
                    ->where('twitch', $helper->remove_hashtags($request->getSendingUser()))
                    ->first();

            $broadcasterrole = Roles::where('code', 'broadcaster')->first();
            $requiredRole = Roles::where('id', $command->roles_id)->first();
            if ($user->inRole($broadcasterrole)) {
                $event->addResponse(Response::msg($request->getSource(), "{$formated}"));
            } elseif ($user->inRole($requiredRole)) {
                $event->addResponse(Response::msg($request->getSource(), "{$formated}"));
            } else {
                $event->addResponse(Response::msg($request->getSource(), "You Do not have the proper permission to use this command"));
            }
        });
        
         // Points Command
        $this->bot->onChannel('/^!points(.*)$/', function($event) {
            $helper = new HelperClass();
            $function = new FunctionsClass();
            $request = $event->getRequest();
            $matches = $event->getMatches();

            $command = CommandsDB::where('command', 'points')->first();

            if (empty($matches[0])) {
                $targetUser = $request->getSendingUser();
            } else {
                $targetUser = $helper->remove_atsign(trim($matches[0]));
            }

            $replace = array(
                '{$user}' => $helper->remove_hashtags($request->getSource()),
                '{$targetuser}' => $targetUser,
                '{$points}' => $function->points($helper->remove_hashtags($request->getSource()), $targetUser),
            );
            $formated = strtr($command->response, $replace);

            $user = Users::where('channel', $helper->remove_hashtags($request->getSource()))
                    ->where('twitch_id', $function->userid($helper->remove_hashtags($request->getSendingUser())))
                    ->where('twitch', $helper->remove_hashtags($request->getSendingUser()))
                    ->first();

            $broadcasterrole = Roles::where('code', 'broadcaster')->first();
            $requiredRole = Roles::where('id', $command->roles_id)->first();
            if ($user->inRole($broadcasterrole)) {
                $event->addResponse(Response::msg($request->getSource(), "{$formated}"));
            } elseif ($user->inRole($requiredRole)) {
                $event->addResponse(Response::msg($request->getSource(), "{$formated}"));
            } else {
                $event->addResponse(Response::msg($request->getSource(), "You Do not have the proper permission to use this command"));
            }
        });

         // Stats Command
        $this->bot->onChannel('/^!stats(.*)$/', function($event) {
            $helper = new HelperClass();
            $function = new FunctionsClass();
            $request = $event->getRequest();
            $matches = $event->getMatches();

            $command = CommandsDB::where('command', 'stats')->first();

            if (empty($matches[0])) {
                $targetUser = $request->getSendingUser();
            } else {
                $targetUser = $helper->remove_atsign(trim($matches[0]));
            }

            $replace = array(
                '{$user}' => $helper->remove_hashtags($request->getSource()),
                '{$targetuser}' => $targetUser,
                '{$points}' => $function->points($helper->remove_hashtags($request->getSource()), $targetUser),
                '{$watchtime}' => $function->watchtime($helper->remove_hashtags($request->getSource()), $targetUser),
                '{$totalmessages}' => $function->totalmessages($helper->remove_hashtags($request->getSource()), $targetUser),
            );
            $formated = strtr($command->response, $replace);

            $user = Users::where('channel', $helper->remove_hashtags($request->getSource()))
                    ->where('twitch_id', $function->userid($helper->remove_hashtags($request->getSendingUser())))
                    ->where('twitch', $helper->remove_hashtags($request->getSendingUser()))
                    ->first();

            $broadcasterrole = Roles::where('code', 'broadcaster')->first();
            $requiredRole = Roles::where('id', $command->roles_id)->first();
            if ($user->inRole($broadcasterrole)) {
                $event->addResponse(Response::msg($request->getSource(), "{$formated}"));
            } elseif ($user->inRole($requiredRole)) {
                $event->addResponse(Response::msg($request->getSource(), "{$formated}"));
            } else {
                $event->addResponse(Response::msg($request->getSource(), "You Do not have the proper permission to use this command"));
            }
        });
        
    }

    /**
     * Returns the Plugin's name
     */
    public function getName() {
        return 'CoreCommands';
    }

}
