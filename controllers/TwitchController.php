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

class TwitchController extends Controller {

    protected $driver = 'Twitch';

    /**
     * {@inheritdoc}
     */
    protected $scopes = ['user:read:email', 'bits:read', 'channel:read:subscriptions'];

    public function __construct() {
        parent::__construct();
//        Socialite::extend($this->driver, /**
//                 *
//                 */
//                function($app) {
//            $providers = \Tohur\Bot\Models\Settings::instance()->get('bot', []);
//            $providers['Twitch']['redirect'] = URL::route('tohur_bot_twitch_callback', true);
//            $provider = Socialite::buildProvider(
//                            TwitchProvider::class, (array) @$providers['Twitch']
//            );
//            return $provider;
//        });
    }

    public function getTwitchRedirect() {
        return Socialite::with($this->driver)->redirect();
    }

    public function getTwitchCallback() {
        $socialUser = Socialite::with($this->driver)->user();

        $user = Owner::where('twitch_id', '=', $socialUser->id)->first();

        return redirect('/backend/system/settings/update/tohur/bot/settings#primarytab-twitch');
    }

}
