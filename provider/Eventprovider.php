<?php

namespace Tohur\Bot\Provider;

use October\Rain\Support\ServiceProvider;

class Eventprovider extends ServiceProvider {

    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        \SocialiteProviders\Manager\SocialiteWasCalled::class => [
            // add your listeners (aka providers) here
            'SocialiteProviders\\Twitch\\TwitchExtendSocialite@handle',
        ],
    ];

}
