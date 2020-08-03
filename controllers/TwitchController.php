<?php

namespace Tohur\Bot\Controllers;

use Backend\Classes\Controller;
use BackendMenu;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Laravel\Socialite\Two\ProviderInterface;
use SocialiteProviders\Manager\OAuth2\User;
use Socialite;
use URL;
use Tohur\Bot\Models\Owner;
use SocialiteProviders\Twitch\Provider as TwitchProvider;
use Tohur\SocialConnect\Classes\Apis\TwitchAPI;

class TwitchController extends Controller {

    protected $driver = 'Twitch';

    /**
     * {@inheritdoc}
     */
    protected $scopes = ['user:read:email', 'bits:read', 'channel:read:subscriptions'];

    public function __construct() {
        parent::__construct();
        Socialite::extend($this->driver, /**
                 *
                 */
                function($app) {
            $providers = \Tohur\Bot\Models\Settings::instance()->get('bot', []);
            $provider = Socialite::buildProvider(
                            TwitchProvider::class, (array) @$providers['Twitch']
            );
            return $provider;
        });
    }

    public function getTwitchRedirect() {
        $scopes = ['analytics:read:extensions', 'analytics:read:games', 'bits:read', 'channel:edit:commercial', 'channel:read:hype_train', 'channel:read:subscriptions', 'clips:edit', 'user:edit', 'user:edit:broadcast', 'user:read:broadcast', 'user:read:email', 'channel_check_subscription', 'channel_commercial', 'channel_editor', 'channel_read', 'channel_stream', 'channel_subscriptions', 'collections_edit', 'user_read', 'user_subscriptions', 'viewing_activity_read', 'channel:moderate', 'chat:edit', 'chat:read', 'whispers:read', 'whispers:edit'];
        return Socialite::with($this->driver)->scopes($scopes)->redirect();
    }

    public function getTwitchCallback() {
        $socialUser = Socialite::with($this->driver)->user();

        $user = Owner::where('twitch_id', '=', $socialUser->id)->first();

        $user->twitch_token = $socialUser->token;
        $user->twitch_refreshToken = $socialUser->refreshToken;
        $user->twitch_expiresIn = $socialUser->expiresIn;
        $user->token_created_at = now();

        $user->save();



        return back();
    }

    public function postStreaminfo(Request $request) {
        $twitch = new TwitchAPI();
        $Settings = \Tohur\Bot\Models\Settings::instance()->get('bot', []);
        $title = $request->title;
        $game = $request->game;
        $user = $twitch->getUser($Settings['Twitch']['channel']);
        $channelID = $user[0]['id'];
        
        $owner = Owner::where('twitch_id', '=', $channelID)->first();
        
        $acessToken = $owner->twitch_token;
        if ($owner->game == $game) {
            $owner->title = $title;
            $owner->save();
        } else {
            $owner->title = $title;
            $owner->game = $game;
            $owner->save();
            Artisan::call('bot:twittergamechange');
        }

        $bot = true;
        
        $post = $twitch->updateChannelinfo($Settings['Twitch']['channel'], $title, $game, $acessToken, $bot = true);

        return response()->json(['success' => 'Sucessfully Updated']);
    }

}
